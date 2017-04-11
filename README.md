Gravity PDF Enhanced Option Fields
==========================

[![Build Status](https://travis-ci.org/GravityPDF/gravity-pdf-enhanced-option-fields.svg?branch=development)](https://travis-ci.org/GravityPDF/gravity-pdf-enhanced-option-fields)

Gravity PDF Enhanced Option Fields is a commercial plugin [available from GravityPDF.com](#). The plugin is hosted here on a public GitHub repository in order to better facilitate community contributions from developers and users. If you have a suggestion, a bug report, or a patch for an issue, feel free to submit it here.

If you are using the plugin on a live site, please purchase a valid license from the website. **We cannot provide support to anyone that does not hold a valid license key**.

# About

This Git repository is for developers who want to contribute to Gravity PDF Enhanced Option Fields. **Don't use it in production**. For production use, [purchase a license and install the packaged version from our online store](#).

The `development` branch is considered our bleeding edge branch, with all new changes pushed to it. The `master` branch is our latest stable version of Gravity PDF Enhanced Option Fields.

# Installation

Before beginning, ensure you have [Git](https://git-scm.com/) and [Composer](https://getcomposer.org/) installed and their commands are globally accessible via the command line.

1. Clone the repository using `git clone https://github.com/GravityPDF/gravity-pdf-enhanced-option-fields/`
1. Open your terminal / command prompt to the Gravity PDF Enhanced Option Fields root directory and run `composer install`
1. Copy the plugin to your WordPress plugin directory (if not there already) and active through your WordPress admin area

# Documentation

Still to come...

# Contributions

You are more than welcome to contribute to Gravity PDF Enhanced Option Fields but we recommend you [open a new issue on GitHub](https://github.com/GravityPDF/gravity-pdf-enhanced-option-fields/issues) and discuss your use-case before creating a pull request.

There are a few guidelines that need to be followed to ensure a smooth pull request. These include:

1. Adhere to the existing code standard which follows [WordPress standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/), with the exception of Yoda conditionals.
1. All PRs must be to the `development` branch.
1. Modifications of the existing codebase must pass all unit tests.
1. Any additions to the plugin must have appropriate unit tests written.
1. PRs that don't pass existing unit testing or do not have the proper tests to accompany the changes will not be merged.
1. Once our team is happy with the PR we'll ask you to squash your branch into a single commit, rebase it onto the development branch and push the changes to GitHub. This ensures we keep a clean Git history.

If you are uncertain whether your PR meets all these requirements, don't worry! If there are problems our friendly team will guide you in the right direction.

### Run Unit Tests

#### PHPUnit

We use PHPUnit to test out all the PHP we write. The tests are located in `tests/phpunit/unit-tests/`

Installing the testing environment is best done using a flavour of Vagrant (try [Varying Vagrant Vagrants](https://github.com/Varying-Vagrant-Vagrants/VVV)).

1. From your terminal SSH into your Vagrant box using the `vagrant ssh` command
2. `cd` into the root of your Gravity PDF Enhanced Option Fields directory
3. Run `bash tests/bin/install.sh gravitypdf_test root root localhost` where `root root` is substituted for your mysql username and password (VVV users can run the command as is).
4. Upon success you can run `vendor/bin/phpunit` and `vendor/bin/phpunit --group ajax`