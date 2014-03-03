(function() {
  'use strict';

  module.exports = function(grunt) {
    grunt.initConfig({
      pkg: grunt.file.readJSON('package.json'),
      notify: {
        watch: {
          options: {
            title: 'Imagine this in a British accent:',
            message: 'grunt tasks: jshint, concat, uglify, sass, cmq'
          }
        }
      },
      concat: {
        options: {
          separator: ';',
          banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */'
        },
        dist: {
          files: {
            'assets/js/app.js': ['assets/js/src/jquery-1.10.2.min.js','assets/js/src/main.js']
          }
        }
      },
      uglify: {
        options: {
          banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n',
          sourceMap: 'assets/js/source-map.js.map'
        },
        dist: {
          files: {
            'assets/js/app.min.js': ['assets/js/app.js']
          }
        }
      },
      jshint: {
        predef: ['grunt'],
        files: ['gruntfile.js'],
        // configure JSHint (documented at http://www.jshint.com/docs/)
        options: {
          globals: {
            jQuery: true,
            console: true,
            module: true
          }
        }
      },
      sass: {
        dist: {
          options: {
            style: 'compressed'
          },
          files: {
            'assets/css/style.min.css': 'assets/css/sass/style.scss'
          }
        },
        dev: {
          options: {
            style: 'expanded'
          },
          files: {
            'assets/css/style.css': 'assets/css/sass/style.scss'
          }
        }
      },
      cmq: {
        options: {
          log: false
        },
        your_target: {
          files: {
            'assets/css': 'assets/css/style.css'
          }
        }
      },
      watch: {
        files: ['<%= jshint.files %>', 'assets/css/sass/*.scss', 'assets/css/sass/foundation/*.scss', 'assets/js/src/*.js'],
        tasks: ['jshint', 'concat', 'uglify', 'sass', 'cmq', 'notify']
      }
    });

    // Load libs
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-combine-media-queries');
    grunt.loadNpmTasks('grunt-devtools');
    grunt.loadNpmTasks('grunt-notify');

    // Register the default tasks
    grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'sass', 'cmq', 'notify']);
  };
}());
