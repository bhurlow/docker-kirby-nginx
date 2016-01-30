

This is a docker image for running [kirby](http://getkirby.com) cms apps

to use:

### pull it

```
docker pull bhurlow/docker-kirby-nginx
```

### run it:

In config.php make sure you add:

```
c::set('url',getenv('BASE_URL'));
```

Then do

```
docker run \
  -i -t \
  -p 3000:80 \
  -v $PWD:/app \
  --env BASE_URL="http://docker:3000" \
  bhurlow/docker-kirby-nginx
```