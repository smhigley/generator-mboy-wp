'use strict';
var util = require('util');
var path = require('path');
var yeoman = require('yeoman-generator');
var chalk = require('chalk');


var MboyWpGenerator = yeoman.generators.Base.extend({
  init: function () {
    this.pkg = yeoman.file.readJSON(path.join(__dirname, '../package.json'));

    this.on('end', function () {
      if (!this.options['skip-install']) {
        this.npmInstall();
      }
    });
  },

  askFor: function () {
    var done = this.async();

    // have Yeoman greet the user
    console.log(this.yeoman);

    // replace it with a short and sweet description of your generator
    console.log(chalk.magenta('You\'re using the fantastic Monkee-Boy Wordpress theme generator.'));

    var prompts = [{
      name: 'siteName',
      message: 'What is the name of this site/theme?',
      default: "New Wordpress Theme"
    },{
      type: 'confirm',
      name: 'customPostTypes',
      message: 'Would you like to enable custom post types?',
      default: false
    },{
      type: 'confirm',
      name: 'themeOptions',
      message: 'Would you like a theme options page?',
      default: false
    },{
      type: 'confirm',
      name: 'customMeta',
      message: 'Would you like to enable custom meta boxes?',
      default: false
    },{
      type: 'confirm',
      name: 'shortcodes',
      message: 'Would you like to enable shortcodes?',
      default: false
    }];

    this.prompt(prompts, function (props) {
      this.siteName = props.siteName;
      this.customPostTypes = props.customPostTypes;
      this.themeOptions = props.themeOptions;
      this.customMeta = props.customMeta;
      this.shortcodes = props.shortcodes;

      done();
    }.bind(this));
  },

  projectdirs: function () {
    var dirs = ['lib', 'assets'];
    var copydirs = ['_templates', '_doc', '_lang', 'assets/css', 'assets/img', 'assets/js'];

    for (var i = 0; i < dirs.length; i++) {
      this.mkdir(dirs[i]);
    }

    for (var i = 0; i < copydirs.length; i++) {
      this.directory(copydirs[i], copydirs[i].replace('_', ''));
    }

    if(this.shortcodes) {
      this.directory('assets/admin', 'assets/admin');
    }

  },

  projectfiles: function () {
    var copies = ['_404.php', '_base.php', '_bower.json', '_gruntfile.js', '_index.php', '_LICENSE.md', '_package.json', '_page.php', '_screenshot.png', '_single.php', 'lib/activation.php', 'lib/cleanup.php', 'lib/comments.php', 'lib/config.php', 'lib/h5bp-htaccess', 'lib/htaccess.php', 'lib/init.php', 'lib/nav.php', 'lib/relative-urls.php', 'lib/rewrites.php', 'lib/titles.php', 'lib/utils.php', 'lib/widgets.php', 'lib/wrapper.php'];

    this.copy('editorconfig', '.editorconfig');
    this.copy('jshintrc', '.jshintrc');

    for (var i = 0; i < copies.length; i++) {
      this.copy(copies[i], copies[i].replace('_', ''));
    }

    if(this.customPostTypes) {
      this.copy('lib/post-types.php', 'lib/post-types.php');
    }

    var templates = ['functions.php', 'style.css', 'lib/custom.php', 'lib/scripts.php', 'lib/options.php'];
    for (var i = 0; i < templates.length; i++) {
      this.template(templates[i], templates[i]);
    }

  }
});

module.exports = MboyWpGenerator;