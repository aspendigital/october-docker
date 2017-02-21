<p align="center"><img alt="Docker Utilities Plugin" style="padding-top: 15px" src="aspendigital.docker-plugin-logo.png"></p>

## AspenDigital.Docker
An October CMS plugin for Docker support.


## Background

The Docker image [aspendigital/octobercms](https://github.com/aspendigital/docker-octobercms) contains [October CMS](https://octobercms.com) pre-installed along with all it's dependencies. This plugin is also introduced via the image's [Dockerfile](https://github.com/aspendigital/docker-octobercms/blob/dda4544e6e232d3a43e873b6db54a73c95755b60/Dockerfile.template#L50)  to establish a default database (sqlite) for the image.

Establishing a default database for the image allows backend access without any additional setup, expediting testing of plugins, themes, etc.

Also, a database is also currently required for the system build parameters to be set.

## Quick Start

To run October CMS using Docker, start a container using our image mapping your local port 80 to the container's port 80:

```shell

$ docker run -p80:80 aspendigital/octobercms:latest

```


Run the container in detached mode using the container name `october` and launch an interactive shell (bash) for the container.


```shell
$ docker run -p80:80 -d --name october aspendigital/octobercms:latest

$ docker exec -it october bash
```

#### Learn more

- [Dockerized October CMS](https://github.com/aspendigital/docker-octobercms): PHP, Composer, October core and dependencies
- [Get started with Docker](https://docs.docker.com/engine/getstarted/)
- Command line references for [`docker run`](https://docs.docker.com/engine/reference/run/) and [`docker exec`](https://docs.docker.com/engine/reference/commandline/exec/)


## Console commands

A summary of the console commands introduced by this plugin.

### docker:up

The `docker:up` console command is used to establish a default database (sqlite) for our base Docker image [aspendigital/octobercms](https://hub.docker.com/r/aspendigital/octobercms/). It is run as a part of our [Docker image build process](https://github.com/aspendigital/docker-octobercms/blob/dda4544e6e232d3a43e873b6db54a73c95755b60/Dockerfile.template#L50).



Running `docker:up` also disables October CMS core and edge updates by default. This can be overridden using the `--edge` option.

__Options__

`--edge`:  Enable edge updates

---

### docker:edge

The `docker:edge` console command updates the container's October CMS configuration to enable core and edge updates.

__Options__

 `--update`: Enable edge updates and automatically run october:update<br>
 `--disable`: Disable edge updates

---

### docker:info

The `docker:info` console command displays the container's current October CMS build, hash, etc.
