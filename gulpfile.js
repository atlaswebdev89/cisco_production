var gulp = require('gulp'),
    
    del    = require('del'),//Подключаем библиотеку для удаления файлов и папок
    cache = require('gulp-cache'), //Кеширование изображений
    imagemin = require('gulp-imagemin');// Сжатие изображение
    cssnano = require("gulp-cssnano"), // Минимизация CSS
    autoprefixer = require('gulp-autoprefixer'), // Проставлет вендорные префиксы в CSS для поддержки старых браузеров
    concat = require("gulp-concat"), // Объединение файлов - конкатенация
    uglify = require("gulp-uglify"), // Минимизация javascript
    rename = require("gulp-rename"); // Переименование файлов

var shell = require("gulp-shell"); // Переименование файлов
var rsync = require('gulp-rsync'); //Синхронизация папок и файлов
var ftp = require('gulp-ftp'); // Передача через ftp
var ftpV = require('vinyl-ftp');
//
//Копирование файлов php html json log из папки app
gulp.task("copy", function () {
    return gulp.src ("app/**/*.+(html|php|json|log|lock)")
            .pipe (gulp.dest("dist/"))
});

//Синхронизация файлов (в случае удаления или перемещения в исходной папке)
gulp.task("rsync-core", function () {
    return gulp.src(
                        "app/core/**")
    .pipe(rsync({
                        root:'app/core/',
                        destination: 'dist/core/',
                        //exclude: ['extensions-front'], // Excludes files from deploy
                        archive: true,
                        silent: true,
                        compress: true,
                        recursive: true,
                        delete:true,
                        clean:true
    }));
});

//Синхронизация проекта с хранилищем для докер контейнера
gulp.task("rsync-docker", function () {
    return gulp.src("dist/**/*", { dot: true })
        .pipe(rsync({
                        destination: '~/web/docker/dockerImagesCisco/',
                        //include: ['sessions'], // Excludes files from deploy
                        archive: true,
                        silent: true,
                        compress: true,
                        recursive: true,
                        delete:true,
                        clean:true
    })); 
});

//Синхронизация проекта с хостингом на beget.com через ftp
gulp.task("ftp-beget", function () {
    return gulp.src('dist/**/*', { dot: true })
        .pipe(ftp({
            host: 'p333709a.bget.ru',
            user: 'p333709a_cisco',
            pass: 'Brestcoredallas89!'
        }));
});

//Выгрузка на хостинг через ftp
gulp.task('deploy-beget', function() {
		var conn = ftpV.create({
		host: 'p333709a.bget.ru',
		user: 'p333709a_cisco',
		password: 'Brestcoredallas89!',
		parallel:  10
	});
        
	return gulp.src('dist/**/*', { dot: true, buffer: false })
		.pipe(conn.dest('/'));
	});

//Копирование htaccess с использованием дополнительнной опции dot:true
gulp.task("htaccess", function () {
    return gulp.src ("app/.htaccess", { dot: true })
            .pipe (gulp.dest("dist/"))
});

//Копирование файлов и папок из папки vendor
gulp.task("vendors", function () {
    return gulp.src ("app/vendor/**/*")
            .pipe (gulp.dest("dist/vendor/"))
});

//Копируем шрифты
gulp.task('fonts', function() {
  return gulp.src('app/frontend/fonts/**/*')
    .pipe(gulp.dest('dist/templates/fonts'))
});

//Копируем папку для хранения сессий
gulp.task('session', 
    shell.task('mkdir dist/sessions && chmod -R 777 dist/sessions')
);

// *************** CSS ******************************************************* 
//Копирование файлов css дополнительных расширений для проекта
gulp.task("copy-css-ext", function () {
    return gulp.src ("app/extensions-front/**/*.+(css)")
            .pipe(rename({dirname: ""})) // убрать директории
            .pipe (gulp.dest("dist/templates/css"))
});

//Оптимизация css
gulp.task("css", function () {
   return gulp.src("app/frontend/css/**/*.css")
        .pipe(concat('main.css'))
        .pipe(autoprefixer())
        .pipe(cssnano())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest("dist/templates/css")); 
});
// *************** END CSS ****************************************************

// *************** JS ******************************************************* 
//Копирование файлов css дополнительных расширений для проекта
gulp.task("copy-js-ext", function () {
    return gulp.src ("app/extensions-front/**/*.js")
            .pipe(rename({dirname: ""})) // убрать директории
            .pipe (gulp.dest("dist/templates/js"))
});
//Оптимизация js
gulp.task("scripts", function() {
    return gulp.src("app/frontend/js/**/*.js") // директория откуда брать исходники
        .pipe(concat('main.js')) // объеденим все js-файлы в один 
        .pipe(uglify()) // вызов плагина uglify - сжатие кода
        .pipe(rename({ suffix: '.min' })) // вызов плагина rename - переименование файла с приставкой .min
        .pipe(gulp.dest("dist/templates/js")); // директория продакшена, т.е. куда сложить готовый файл
});

// *************** END JS ****************************************************

//Оптимизация и копирование изображений
gulp.task("images", function() {
    return gulp.src("app/frontend/images/**/*.+(png|jpeg|jpg|svg|gif|ico)")
            .pipe(cache(imagemin({
                progressive: true,
                svgoPlugins: [{ removeViewBox: false }],
                interlaced: true
            })))
            .pipe(gulp.dest("dist/templates/images"))
});

//Следить за изменениями в файлах
gulp.task ("watcher", function () {
    gulp.watch('app/core/**',   gulp.parallel('rsync-core'));
    gulp.watch('app/**/*.+(html|php|json|log)',   gulp.parallel('copy'));
    gulp.watch("app/vendor/**/*",  gulp.parallel('vendors'));
    gulp.watch("app/frontend/fonts/**/*",  gulp.parallel('fonts'));
    gulp.watch("app/frontend/images/**/*.+(png|jpeg|jpg|svg|gif|ico)",  gulp.parallel('images'));
    gulp.watch("app/frontend/css/**/*.css", gulp.parallel("css"));
    gulp.watch("app/frontend/js/**/*.js", gulp.parallel("scripts"));
    gulp.watch("app/extensions-front/**/*.+(css)", gulp.parallel("copy-css-ext"));
    gulp.watch("app/templates/js/**/*.js", gulp.parallel("scripts"));
    gulp.watch("app/extensions-front/**/*.js", gulp.parallel("copy-js-ext"));
});

//Для удаления папки dist перед сборкой
gulp.task("del", function () {
   return del('dist'); // Удаляем папку dist перед сборкой 
});

//Очистка кеша
gulp.task('clear', function (callback) {
	return cache.clearAll();
})

gulp.task("default", gulp.parallel(
                                    "copy", 
                                    "copy-css-ext", 
                                    "copy-js-ext",
                                    "htaccess", 
                                    "vendors", 
                                    "images",  
                                    "fonts",
                                    "rsync-core",
                                    "css",
                                    "scripts", 
                                    "watcher"
                                              ));
gulp.task("build", gulp.series(
                                    "del", 
                                    "clear", 
                                    "copy", 
                                    "copy-css-ext", 
                                    "copy-js-ext",
                                    "htaccess", 
                                    "vendors", 
                                    "session", 
                                    "images",  
                                    "fonts",
                                    "css",
                                    "scripts"
                                                ));


