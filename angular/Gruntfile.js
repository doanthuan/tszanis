/**
 * Created by thuan on 12/22/2014.
 */
module.exports = function(grunt) {

    grunt.loadNpmTasks('grunt-angular-gettext');

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        nggettext_extract:{
            pot:{
                files:{
                    'po/template.pot':['app/**/*.html']
                }
            }
        },
        nggettext_compile:{
            all:{
                files:{
                    'app/js/translation.js':['po/*.po']
                }
            }
        }
    });


};
