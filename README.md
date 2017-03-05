<p align="center"><img alt="Docker Utilities Plugin" style="padding-top: 15px" src="aspendigital.docker-plugin-logo.png"></p>

## AspenDigital.Docker
An October CMS plugin for Docker support.

__Note:__ This plugin is __no longer__ installed as a part of the [aspendigital/octobercms](https://github.com/aspendigital/docker-octobercms) Docker image build.


## Background

The [aspendigital/octobercms](https://github.com/aspendigital/docker-octobercms) Docker image contains [October CMS](https://octobercms.com) along with all it's dependencies. This plugin features console commands to help manage October CMS installed in the container.  


#### Learn more

- [Dockerized October CMS](https://github.com/aspendigital/docker-octobercms): PHP, Composer, October core and dependencies
- [Get started with Docker](https://docs.docker.com/engine/getstarted/)

## Console commands

A summary of the console commands introduced by this plugin.

### docker:up

The `docker:up` console command is used to set the system build parameters for our base Docker image [aspendigital/octobercms](https://hub.docker.com/r/aspendigital/octobercms/).

---

### docker:edge

The `docker:edge` console command updates the container's October CMS configuration to enable core and edge updates.

__Options__

 `--update`: Enable edge updates and automatically run october:update<br>
 `--disable`: Disable edge updates

---

### docker:info

The `docker:info` console command displays the container's current October CMS build, hash, etc.
