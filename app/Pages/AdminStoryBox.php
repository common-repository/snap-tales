<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Pages;

// @phpcs:disable WordPress.Security.NonceVerification.Missing
// @phpcs:disable WordPress.Security.NonceVerification.Recommended

use BeycanPress\SnapTales\PluginHero\Page;
use BeycanPress\SnapTales\PluginHero\Hook;
use BeycanPress\SnapTales\PluginHero\Table;
use BeycanPress\SnapTales\PluginHero\Helpers;
use BeycanPress\SnapTales\Models\AdminStoryBox as StoryBoxModel;

class AdminStoryBox extends Page
{
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
            'priority' => 9,
            'parent' => 'snap-tales',
            'pageName' => esc_html__('Story box', 'snap-tales'),
        ]);
    }

    /**
     * @return void
     */
    public function page(): void
    {
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
        if (isset($_POST['add-new'])) {
            if (!Helpers::checkNonceField()) {
                Helpers::basicNotice(esc_html__('Sorry something went wrong.', 'snap-tales'), 'error', true);
            }

            $title = isset($_POST['title']) ? sanitize_title($_POST['title']) : null;
            $thumbnail = isset($_POST['thumbnail']) ? esc_url_raw($_POST['thumbnail']) : null;

            Hook::callAction('admin_story_box_add_new', $title, $thumbnail);

            if (!$title || !$thumbnail) {
                Helpers::basicNotice(
                    esc_html__('Story box title and story box thumbnail are required!', 'snap-tales'),
                    'error',
                    true
                );
            } else {
                if ($this->storyBoxModel->findOneBy(['title' => $title])) {
                    Helpers::basicNotice(esc_html__('Story box title already exists!', 'snap-tales'), 'error', true);
                } else {
                    $result = $this->storyBoxModel->insert([
                        'status' => 1,
                        'title' => $title,
                        'thumbnail' => $thumbnail,
                        'updatedAt' => current_time('mysql'),
                    ]);

                    if (!$result) {
                        Helpers::basicNotice(
                            esc_html__('There was a problem adding the story box!', 'snap-tales'),
                            'error',
                            true
                        );
                    } else {
                        Helpers::jsRedirect($this->getUrl() . '&last-process=add-new');
                    }
                }
            }
        }

        Helpers::viewEcho('pages/admin-story-box/add-new');
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

            $id = isset($_POST['id']) ? absint($_POST['id']) : null;
            $status = isset($_POST['status']) ? absint($_POST['status']) : null;
            $title = isset($_POST['title']) ? sanitize_title($_POST['title']) : null;
            $thumbnail = isset($_POST['thumbnail']) ? esc_url_raw($_POST['thumbnail']) : null;

            Hook::callAction('admin_story_box_edit', $id, $title, $thumbnail, $status);

            if (!$title || !$thumbnail) {
                Helpers::basicNotice(
                    esc_html__('Story box title and story box thumbnail are required!', 'snap-tales'),
                    'error',
                    true
                );
            } else {
                $result = $this->storyBoxModel->update([
                    'title' => $title,
                    'status' => $status,
                    'thumbnail' => $thumbnail,
                    'updatedAt' => current_time('mysql'),
                ], ['id' => $id]);

                if (!$result) {
                    Helpers::basicNotice(
                        esc_html__('There was a problem edited the story box!', 'snap-tales'),
                        'error',
                        true
                    );
                } else {
                    Helpers::jsRedirect($this->getUrl() . '&last-process=edit');
                }
            }
        }

        $storyBoxId = isset($_GET['edit']) ? absint($_GET['edit']) : null;

        if (!$storyBoxId) {
            Helpers::basicNotice(esc_html__('Missing parameter!', 'snap-tales'), 'error', true);
        } else {
            Helpers::viewEcho('pages/admin-story-box/edit', [
                'storyBox' => $this->storyBoxModel->findOneBy(['id' => $storyBoxId]),
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
                Helpers::basicNotice(esc_html__('Story box successfully added.', 'snap-tales'), 'success', true);
            } elseif ('edit' == $process) {
                Helpers::basicNotice(esc_html__('Story box successfully edited.', 'snap-tales'), 'success', true);
            }
        }

        if (isset($_GET['not-found-story-box'])) {
            Helpers::basicNotice(
                esc_html__('In order to create a story, you must first create a story box.', 'snap-tales'),
                'error',
                true
            );
        }

        $this->deleteProcess();

        Helpers::viewEcho('pages/admin-story-box/list', [
            'table' => $this->createTable()
        ]);
    }

    /**
     * @return Table
     */
    private function createTable(): Table
    {
        $params = [];

        if (isset($_GET['s'])) {
            $params[] = ['title', 'LIKE', sanitize_text_field($_GET['s'])];
        }

        $table = new Table($this->storyBoxModel, $params);

        $table->setColumns([
            'id'        => esc_html__('ID', 'snap-tales'),
            'title'     => esc_html__('Title', 'snap-tales'),
            'thumbnail' => esc_html__('Thumbnail', 'snap-tales'),
            'status'    => esc_html__('Status', 'snap-tales'),
            'updatedAt' => esc_html__('Updated at', 'snap-tales'),
            'createdAt' => esc_html__('Created at', 'snap-tales'),
            'edit'      => esc_html__('Edit', 'snap-tales'),
            'delete'    => esc_html__('Delete', 'snap-tales')
        ]);

        $table->setOptions([
            'search' => [
                'id' => 'search-box',
                'title' => esc_html__('Search...', 'snap-tales')
            ]
        ]);

        $table->setOrderQuery(
            ['id', 'DESC']
        );

        $table->setSortableColumns([
            'status'    => 'status',
            'updatedAt' => 'updatedAt',
            'createdAt' => 'createdAt'
        ]);

        $table->addHooks([
            'thumbnail' => function ($args): string {
                return '<img width="33" height="33" src="' . $args->thumbnail . '">';
            },
            'status' => function ($args): string {
                return $args->status ? esc_html__('Active', 'snap-tales') : esc_html__('Passive', 'snap-tales');
            },
            'createdAt' => function ($args): string {
                return date_i18n(get_option('date_format'), strtotime($args->createdAt));
            },
            'updatedAt' => function ($args): string {
                return date_i18n(get_option('date_format'), strtotime($args->updatedAt));
            },
            'edit' => function ($args): string {
                ob_start();
                // phpcs:disable
                ?>
                <a href="<?php echo esc_url($this->getUrl() . '&edit=' . $args->id); ?>" class="button">
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

            $id = isset($_POST['delete']) ? absint($_POST['delete']) : null;
            if (!$id) {
                Helpers::basicNotice(esc_html__('Missing parameter!', 'snap-tales'), 'error', true);
            }

            Hook::callAction('admin_story_box_delete', $id);

            $result = $this->storyBoxModel->delete(['id' => $id]);

            if (!$result) {
                Helpers::basicNotice(
                    esc_html__('There was a problem deleted the story box!', 'snap-tales'),
                    'error',
                    true
                );
            } else {
                Helpers::basicNotice(esc_html__('Story box deleted successfully.', 'snap-tales'), 'success', true);
            }
        }
    }
}