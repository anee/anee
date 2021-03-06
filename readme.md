[Anee](http://anee.cz)
===================================

[![Build Status](https://travis-ci.org/anee/anee.svg?branch=master)](https://travis-ci.org/anee/anee)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com) 
[![SecurityHeaders.io](https://securityheadersiobadges.azurewebsites.net/create/badge?domain=http://anee.cz)](https://securityheaders.io/?q=http%3A%2F%2Fanee.cz&hide=on)

Anee is place for sharing tracks and photos. I develop Anee in my free time and for non-commercial using.

![ScreenShot](https://raw.github.com/anee/anee/master/examples/anee.png)

Reference
---------------
[Anee (https://github.com/anee/anee) - create test users](https://gist.github.com/ldrahnik/48b558291640c937487808db0ec5178f)

User getting started
---------------
Interface tries to be intuitive. Just [register](http://anee.cz/Register/In) and try it yourself. If you dont know anything do not be shy to contact me.

Dev getting started
--------------
```
  git clone git@github.com:anee/anee.git
  cd anee
  sh init.sh
  # create manually database with name `anee`
  php ./www/index.php orm:schema-tool:create
```


```
  sh clean.sh
```

API
-----
+ [Wiki](https://github.com/anee/anee/wiki/Rest-API)
+ [Apiary.io](http://docs.anee.apiary.io/)

Reporting bugs
---------------
If something is wrong, use feedback form in application or if you think that it's bug you can report issue [here](https://github.com/anee/app/issues) or if you know how fix that you could send [pull request](https://github.com/anee/app/pulls).
