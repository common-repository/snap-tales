import gulp from 'gulp';
import * as nodeSass from 'sass';
import gulpSass from 'gulp-sass';
import concat from 'gulp-concat';
import minifyCSS from 'gulp-csso';
import minifyJS from 'gulp-uglify';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'gulp-autoprefixer';
const sass = gulpSass(nodeSass);

const tasks = [
    'js-backend',
    'js-gutenberg',
    'js-tinymce',
];

const watches = [];

for (let index = 0; index < tasks.length; index++) {
    let task = tasks[index];
    let type = task.split("-")[0];
    let file = task.split("-");
    file = file[1];

    if ( type === 'js' ) {
        gulp.task(task, () => {
            return gulp.src('src/js/'+file+'.js')
            .pipe(sourcemaps.init())
            .pipe(concat(''+file+'.min.js'))
            .pipe(minifyJS({
                mangle: false
            }))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('assets/js'));
        });
        watches.push(gulp.watch('src/js/'+file+'.js', gulp.series(task)));
    } else {
        gulp.task(task, () => {
            return gulp.src('src/scss/'+file+'.scss')
            .pipe(sourcemaps.init())
            .pipe(sass())
            .pipe(autoprefixer())
            .pipe(concat(''+file+'.min.css'))
            .pipe(minifyCSS())
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('assets/css'));
        });
        watches.push(gulp.watch('src/scss/'+file+'.scss', gulp.series(task)));
    }
}
    
gulp.task('watch', () => {
    for (let index = 0; index < watches.length; index++) {
        watches[index];
    }
});
    
gulp.task('default', async () => {
    tasks.push("watch");
    gulp.series(tasks)();
});
