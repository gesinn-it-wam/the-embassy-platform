This folder contains files for customizing semantic::core:

## custom-settings.php
```php
<?php
  $wgYourSetting=true;
```

## custom.less
Your skin customizations, e.g.

```css
@brand-primary:             #C80000;

// Panels
@panel-default-border:      @brand-primary;
@panel-default-heading-bg:  @brand-primary;

// White text for dark primary color
@brand-default-text:        #FFF;
@panel-link-color:          #FFF;

// Optional logo padding
#p-logo{ margin-left: 0; }
#mw-navigation .navbar-brand img{
        padding:3px;
}


```

## logo.png
Your logo, ideally sized 50x45 pixels, including some padding