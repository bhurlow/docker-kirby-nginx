

This is a docker image for running [kirby](http://getkirby.com) cms apps

to use:

### pull it

```
docker pull bhurlow/docker-kirby-nginx
```

### run it:
```
docker run -i -t -p 3000:80 -v $PWD:/app bhurlow/docker-kirby-nginx
```

note, you'll have to update your site url for css assets to load properly:

in site.php:

```
<?php
$kirby = kirby();
$kirby->urls->index = 'http://docker:3000';
```

