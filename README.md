[![Latest Stable Version](https://poser.pugx.org/cvette/neos-assetsource-shutterstock/v/stable)](https://packagist.org/packages/cvette/neos-assetsource-shutterstock) [![Total Downloads](https://poser.pugx.org/cvette/neos-assetsource-shutterstock/downloads)](https://packagist.org/packages/cvette/google-tag-manager) [![License](https://poser.pugx.org/cvette/neos-assetsource-shutterstock/license)](https://packagist.org/packages/cvette/neos-assetsource-shutterstock)

# shutterstock Asset Source for Neos
This package provides an asset source for *shutterstock.com*. It is limited to preview images at the moment.

## Usage 
1. Install the package via composer `composer require cvette/neos-assetsource-shutterstock`
2. Create an app on https://developers.shutterstock.com
3. Configure the consumer key and secret in the settings

## Options

`removeImageIdFromPreview`: Remove the image Id from preview images when imported. Defaults to `true`

`queryParams`: The following search parameters can be configured at the moment: `imageType`, `category`, `safe`

![Neos Media Browser](https://i.imgur.com/tX8jFk9.png)
