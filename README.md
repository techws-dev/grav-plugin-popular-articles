# Popular Articles Plugin

**This README.md file should be modified to describe the features, installation, configuration, and general usage of the plugin.**

The **Popular Articles** Plugin is an extension for [Grav CMS](http://github.com/getgrav/grav). Display a list of links to the most popular articles from a blog.

> NOTE: This plugin requires the admin plugin to be installed.

## Installation

Installing the Popular Articles plugin can be done in one of three ways: The GPM (Grav Package Manager) installation method lets you quickly install the plugin with a simple terminal command, the manual method lets you do so via a zip file, and the admin method lets you do so via the Admin Plugin.

### GPM Installation (Preferred)

To install the plugin via the [GPM](http://learn.getgrav.org/advanced/grav-gpm), through your system's terminal (also called the command line), navigate to the root of your Grav-installation, and enter:

    bin/gpm install popular-articles

This will install the Popular Articles plugin into your `/user/plugins`-directory within Grav. Its files can be found under `/your/site/grav/user/plugins/popular-articles`.

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `popular-articles`. You can find these files on [GitHub](https://github.com//grav-plugin-popular-articles) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/popular-articles
	
> NOTE: This plugin is a modular component for Grav which may require other plugins to operate, please see its [blueprints.yaml-file on GitHub](https://github.com//grav-plugin-popular-articles/blob/master/blueprints.yaml).

### Admin Plugin

If you use the Admin Plugin, you can install the plugin directly by browsing the `Plugins`-menu and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/popular-articles/popular-articles.yaml` to `user/config/plugins/popular-articles.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled:            true
blog_route:         /blog   # route under where the articles can be found
articles_count:     5       # number of articles displayed
```

Note that if you use the Admin Plugin, a file with your configuration named popular-articles.yaml will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.

## Usage

Just add the lines in the templates you want to display the list:

```twig
{% if config.plugins['popular-articles'].enabled %}
	{% include 'partials/popular_articles.html.twig' %}
{% endif %}
```

Don't forget to enable the plugin in the plugin configuration (see above).

It's recommended to override the original template to suit your needs (then save it to templates/partials/popular_articles.html.twig in your theme):

```twig
{% set articles_list = popular_articles.get() %}

<h4>
    {{ 'PLUGIN_POPULAR_ARTICLES.POPULAR_ARTICLES'|t }}
</h4>

<ul>
    {% for article in articles_list %}
    <li>
        <a href="{{ base_url }}{{ article.route }}">
            {{ article.title }}
        </a>
    </li>
    {% endfor %}
</ul>
```

## To Do

- add title translations (only english and french right now)

