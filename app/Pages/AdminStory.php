<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Pages;

// @phpcs:disable WordPress.Security.NonceVerification.Missing
// @phpcs:disable WordPress.Security.NonceVerification.Recommended

use BeycanPress\SnapTales\PluginHero\Page;
use BeycanPress\SnapTales\PluginHero\Hook;
use BeycanPress\SnapTales\PluginHero\Table;
use BeycanPress\SnapTales\PluginHero\Helpers;
use BeycanPress\SnapTales\Models\AdminStory as StoryModel;
use BeycanPress\SnapTales\Models\AdminStoryBox as StoryBoxModel;

class AdminStory extends Page
{
    /**
     * @var StoryModel
     */
    private StoryModel $storyModel;

    /**
     * @var StoryBoxModel
     */
    private StoryBoxModel $storyBoxModel;

    /**
     * Class construct
     * @return void
     */
    public function __construct()
    {
        parent::__construct([
            'priority' => 1,
            'subMenu' => true,
            'slug' => 'snap-tales',
            'icon' => 'dashicons-format-gallery',
            'pageName' => esc_html__('Snap Tales', 'snap-tales'),
            'subMenuPageName' => esc_html__('Stories', 'snap-tales')
        ]);
    }

    /**
     * @return void
     */
    public function page(): void
    {
        $this->storyModel = new StoryModel();
        $this->storyBoxModel = new StoryBoxModel();

        if (isset($_GET['add-new']) || isset($_GET['edit'])) {
            wp_enqueue_media();
            Helpers::addScript('backend.min.js', ['wp-i18n']);
        }

        if (isset($_GET['add-new'])) {
            $this->addNew();
        } elseif (isset($_GET['edit'])) {
            $this->edit();
        } else {
            $this->list();
        }
    }

    /**
     * @return void
     */
    private function addNew(): void
    {
        $storyBoxes = $this->storyBoxModel->findAll();

        if (empty($storyBoxes)) {
            Helpers::jsRedirect(admin_url('admin.php?page=snap-tales-story-box&not-found-story-box=1'));
        }

        if (isset($_POST['add-new'])) {
            if (!Helpers::checkNonceField()) {
                Helpers::basicNotice(esc_html__('Sorry something went wrong.', 'snap-tales'), 'error', true);
            }

            $mediaURL = isset($_POST['media_url']) ? esc_url_raw($_POST['media_url']) : null;
            $storyBoxId = isset($_POST['story_box_id']) ? absint($_POST['story_box_id']) : null;
            $externalURL = isset($_POST['external_url']) ? esc_url_raw($_POST['external_url']) : null;
            $showUntil = isset($_POST['show_until']) ? sanitize_text_field($_POST['show_until']) : null;

            $showUntil = empty($showUntil) ? null : $showUntil;
            $externalURL = empty($externalURL) ? null : $externalURL;

            Hook::callAction('admin_story_add_new', $storyBoxId, $mediaURL);

            if (!$mediaURL || !$storyBoxId) {
                Helpers::basicNotice(esc_html__('Media URL are required!', 'snap-tales'), 'error', true);
            } else {
                $result = $this->storyModel->insert([
                    'status' => 1,
                    'mediaURL' => $mediaURL,
                    'showUntil' => $showUntil,
                    'parentId' => $storyBoxId,
                    'externalURL' => $externalURL,
                    'userId' => get_current_user_id(),
                    'updatedAt' => current_time('mysql')
                ]);

                if (!$result) {
                    Helpers::basicNotice(
                        esc_html__('There was a problem adding the story!', 'snap-tales'),
                        'error',
                        true
                    );
                } else {
                    Helpers::jsRedirect($this->getUrl() . '&last-process=add-new');
                }
            }
        }

        Helpers::viewEcho('pages/admin-story/add-new', [
            'storyBoxes' => $storyBoxes
        ]);
    }

    /**
     * @return void
     */
    private function edit(): void
    {
        if (isset($_POST['edit'])) {
            if (!Helpers::checkNonceField()) {
                Helpers::basicNotice(esc_html__('Sorry something went wrong.', 'snap-tales'), 'error', true);
            }

            $status = isset($_POST['status']) ? absint($_POST['status']) : null;
            $storyId = isset($_POST['story_id']) ? absint($_POST['story_id']) : null;
            $storyBoxId = isset($_POST['story_box_id']) ? absint($_POST['story_box_id']) : null;
            $mediaURL = isset($_POST['media_url']) ? esc_url_raw($_POST['media_url']) : null;
            $externalURL = isset($_POST['external_url']) ? esc_url_raw($_POST['external_url']) : null;
            $showUntil = isset($_POST['show_until']) ? sanitize_text_field($_POST['show_until']) : null;

            $showUntil = empty($showUntil) ? null : $showUntil;
            $externalURL = empty($externalURL) ? null : $externalURL;

            Hook::callAction('admin_story_edit', $storyId, $storyBoxId, $status, $mediaURL);

            if (!$mediaURL || !$storyBoxId) {
                Helpers::basicNotice(esc_html__('Media URL are required!', 'snap-tales'), 'error', true);
            } else {
                $result = $this->storyModel->update([
                    'status' => $status,
                    'mediaURL' => $mediaURL,
                    'showUntil' => $showUntil,
                    'parentId' => $storyBoxId,
                    'externalURL' => $externalURL,
                    'updatedAt' => current_time('mysql')
                ], ['id' => $storyId]);

                if (!$result) {
                    Helpers::basicNotice(
                        esc_html__('There was a problem edited the story!', 'snap-tales'),
                        'error',
                        true
                    );
                } else {
                    Helpers::jsRedirect($this->getUrl() . '&last-process=edit');
                }
            }
        }

        $storyId = isset($_GET['edit']) ? absint($_GET['edit']) : null;

        if (!$storyId) {
            Helpers::basicNotice(esc_html__('Missing parameter!', 'snap-tales'), 'error', true);
        } else {
            Helpers::viewEcho('pages/admin-story/edit', [
                'story' => $this->storyModel->findOneBy(['id' => $storyId])
            ]);
        }
    }

    /**
     * @return void
     */
    private function list(): void
    {
        if (isset($_GET['last-process'])) {
            $process = sanitize_text_field($_GET['last-process']);
            if ('add-new' == $process) {
                Helpers::basicNotice(esc_html__('Story successfully added.', 'snap-tales'), 'success', true);
            } elseif ('edit' == $process) {
                Helpers::basicNotice(esc_html__('Story successfully edited.', 'snap-tales'), 'success', true);
            }
        }

        $this->deleteProcess();

        Helpers::viewEcho('pages/admin-story/list', [
            'table' => $this->createTable()
        ]);
    }

    /**
     * @return Table
     */
    private function createTable(): Table
    {
        $params = [];
        $status = isset($_GET['status']) && '' != $_GET['status'] ? absint($_GET['status']) : null;
        $storyBoxId = isset($_GET['story-box-id']) && '' != $_GET['story-box-id']
        ? absint($_GET['story-box-id']) : null;
        $endDate = isset($_GET['end-date']) && '' != $_GET['end-date']
        ? sanitize_text_field($_GET['end-date']) : null;
        $startDate = isset($_GET['start-date']) &&  '' != $_GET['start-date']
        ? sanitize_text_field($_GET['start-date']) : null;

        if ($storyBoxId) {
            $params['parentId'] = $storyBoxId;
        }

        if (!is_null($status)) {
            $params['status'] = $status;
        }

        if ($startDate && $endDate) {
            $params[] = [
                'createdAt',
                'BETWEEN',
                [
                    $startDate,
                    $endDate
                ]
            ];
        } elseif ($startDate) {
            $params[] = [
                'createdAt',
                '>=',
                $startDate
            ];
        } elseif ($endDate) {
            $params[] = [
                'createdAt',
                '<=',
                $endDate
            ];
        }

        $table = new Table($this->storyModel, $params);
        $storyBoxes = $this->storyBoxModel->findAll();

        $table->setColumns([
            'id'          => esc_html__('ID', 'snap-tales'),
            'parentId'    => esc_html__('Story box ID', 'snap-tales'),
            'mediaURL'    => esc_html__('Media URL', 'snap-tales'),
            'externalURL' => esc_html__('External URL', 'snap-tales'),
            'status'      => esc_html__('Status', 'snap-tales'),
            'showUntil'   => esc_html__('Show until', 'snap-tales'),
            'updatedAt'   => esc_html__('Updated at', 'snap-tales'),
            'createdAt'   => esc_html__('Created at', 'snap-tales'),
            'edit'        => esc_html__('Edit', 'snap-tales'),
            'delete'      => esc_html__('Delete', 'snap-tales')
        ]);

        $table->setOrderQuery(
            ['id', 'DESC']
        );

        $table->setSortableColumns([
            'parentId'  => 'parentId',
            'status'    => 'status',
            'updatedAt' => 'updatedAt',
            'createdAt' => 'createdAt'
        ]);

        $table->addHeaderElements(function () use ($storyBoxes): void {
            // phpcs:disable
            ?>
            <form>
                
                <?php if (!empty($_GET)) {
                    foreach ($_GET as $key => $value) {
                        $key = sanitize_text_field($key);
                        $value = sanitize_text_field($value);
                        ?>
                        <input type="hidden" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_html($value); ?>"/>
                    <?php }
                } ?>

                <select name="story-box-id">
                    <option value=""><?php echo esc_html__('Filter by story box', 'snap-tales'); ?></option>
                    <?php foreach ($storyBoxes as $key => $value) { ?>
                        <option value="<?php echo esc_attr($value->id); ?>" <?php echo isset($_GET['story-box-id']) && absint($_GET['story-box-id']) == $value->id ? 'selected' : null ?>>
                            <?php echo esc_html($value->title); ?>
                        </option>
                    <?php } ?>
                </select>

                <select name="status">
                    <option value=""><?php echo esc_html__('Filter by status', 'snap-tales'); ?></option>
                    <option value="1" <?php echo isset($_GET['status']) && absint($_GET['status']) == 1 ? 'selected' : null ?>>
                        <?php echo esc_html__('Active', 'snap-tales'); ?>
                    </option>
                    <option value="0" <?php echo isset($_GET['status']) && absint($_GET['status']) == 0 ? 'selected' : null ?>>
                        <?php echo esc_html__('Passive', 'snap-tales'); ?>
                    </option>
                </select>

                <label for="start-date"><?php echo esc_html__('Start date', 'snap-tales'); ?></label>
                <input type="date" name="start-date" id="start-date" value="<?php echo isset($_GET['start-date']) ? esc_attr(sanitize_text_field($_GET['start-date'])) : null; ?>">

                <label for="end-date"><?php echo esc_html__('End date', 'snap-tales'); ?></label>
                <input type="date" name="end-date" id="end-date" value="<?php echo isset($_GET['end-date']) ? esc_attr(sanitize_text_field($_GET['end-date'])) : null; ?>">

                <button class="button"><?php echo esc_html__('Filter', 'snap-tales'); ?></button>
                <a href="<?php echo esc_url(admin_url('admin.php?page=snap-tales')) ?>" class="button">
                    <?php echo esc_html__('Reset', 'snap-tales'); ?>
                </a>
            </form>
            <?php
            // phpcs:enable
        });

        $storyBoxTitles = [];
        foreach ($storyBoxes as $storyBox) {
            $storyBoxTitles[$storyBox->id] = $storyBox->title;
        }

        $table->addHooks([
            'status' => function ($args): string {
                return $args->status ? esc_html__('Active', 'snap-tales') : esc_html__('Passive', 'snap-tales');
            },
            'parentId' => function ($args) use ($storyBoxTitles): string {
                if (!$args->parentId) {
                    return esc_html__('Not found', 'snap-tales');
                }

                return $args->parentId . ' - ' . $storyBoxTitles[$args->parentId];
            },
            'externalURL' => function ($args): string {
                if (empty($args->externalURL)) {
                    return esc_html__('None', 'snap-tales');
                }
                // phpcs:ignore
                return '<a href="' . $args->externalURL . '" class="button" target="_blank">' . esc_html__('Open', 'snap-tales') . '</a>';
            },
            'mediaURL' => function ($args): string {
                // phpcs:ignore
                return '<a href="' . $args->mediaURL . '" class="button" target="_blank">' . esc_html__('Open', 'snap-tales') . '</a>';
            },
            'showUntil' => function ($args): string {
                if (!$args->showUntil) {
                    return esc_html__('None', 'snap-tales');
                }

                return date_i18n('F j, Y - H:i', strtotime($args->showUntil));
            },
            'createdAt' => function ($args): string {
                return date_i18n(get_option('date_format'), strtotime($args->createdAt));
            },
            'updatedAt' => function ($args): string {
                return date_i18n(get_option('date_format'), strtotime($args->updatedAt));
            },
            'edit' => function ($args): string {
                // phpcs:disable
                ob_start();
                ?>
                <a href="<?php echo esc_url(Helpers::getCurrentUrl() . '&edit=' . $args->id); ?>" class="button">
                    <?php echo esc_html__('Edit', 'snap-tales'); ?>
                </a>
                <?php
                // phpcs:enable
                return ob_get_clean();
            },
            'delete' => function ($args): string {
                ob_start();
                // phpcs:disable
                ?>
                <form action="<?php echo esc_url(Helpers::getCurrentUrl()); ?>" method="post">
                    <?php Helpers::createNewNonceField(); ?>
                    <input type="hidden" name="delete" value="<?php echo esc_attr($args->id); ?>">
                    <button class="button"><?php echo esc_html__('Delete', 'snap-tales'); ?></button>
                </form>
                <?php
                // phpcs:enable
                return ob_get_clean();
            },
        ]);

        return $table->createDataList();
    }

    /**
     * @return void
     */
    private function deleteProcess(): void
    {
        // @phpcs:disable WordPress.Security.NonceVerification.Missing
        if (isset($_POST['delete'])) {
            if (!Helpers::checkNonceField()) {
                Helpers::basicNotice(esc_html__('Sorry something went wrong.', 'snap-tales'), 'error', true);
            }

            $storyId = isset($_POST['delete']) ? absint($_POST['delete']) : null;
            if (!$storyId) {
                Helpers::basicNotice(esc_html__('Missing parameter!', 'snap-tales'), 'error', true);
            }

            Hook::callAction('admin_story_delete', $storyId);

            $result = $this->storyModel->delete(['id' => $storyId]);

            if (!$result) {
                Helpers::basicNotice(
                    'error',
                    esc_html__('There was a problem deleted the story box!', 'snap-tales'),
                    true
                );
            } else {
                Helpers::basicNotice(esc_html__('Story box deleted successfully.', 'snap-tales'), 'success', true);
            }
        }
    }
}
