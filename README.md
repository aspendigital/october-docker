<p align="center"><img alt="Docker Utilities Plugin" style="padding-top: 15px" src="aspendigital.docker-plugin-logo.png"></p>

## AspenDigital.Docker
An October CMS plugin for Docker support.


## Background

The [aspendigital/octobercms](https://github.com/aspendigital/docker-octobercms) Docker image contains [October CMS](https://octobercms.com) along with all it's dependencies. This plugin is introduced via the image's [Dockerfile](https://github.com/aspendigital/docker-octobercms/blob/dda4544e6e232d3a43e873b6db54a73c95755b60/Dockerfile.template#L50) primarily to set the system build parameters.

#### Learn more

- [Dockerized October CMS](https://github.com/aspendigital/docker-octobercms): PHP, Composer, October core and dependencies
- [Get started with Docker](https://docs.docker.com/engine/getstarted/)

## Console commands

A summary of the console commands introduced by this plugin.

### docker:up

The `docker:up` console command is used to set the system build parameters for our base Docker image [aspendigital/octobercms](https://hub.docker.com/r/aspendigital/octobercms/). It is run as a part of our [Docker image build process](https://github.com/aspendigital/docker-octobercms/blob/dda4544e6e232d3a43e873b6db54a73c95755b60/Dockerfile.template#L50).

---

### docker:edge

The `docker:edge` console command updates the container's October CMS configuration to enable core and edge updates.

__Options__

 `--update`: Enable edge updates and automatically run october:update<br>
 `--disable`: Disable edge updates

---

### docker:info

The `docker:info` console command displays the container's current October CMS build, hash, etc.
