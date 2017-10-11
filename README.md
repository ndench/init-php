# InitPHP

This tutorial is aimed at PHP beginners. It will take you through setting up a PHP environment
and structuring your code. It's assumed you already know programming basics such as `if` 
statements and `for` loops. 

We will be building a basic PHP site which allows the user to search [giphy](giphy.com).

## Initial setup


### Prerequisites

We'll need a few things installed to get started:

* [Install Virtualbox](https://www.virtualbox.org/wiki/Downloads)
* [Install Vagrant](https://www.vagrantup.com/downloads.html)


### Create the project

To create a new project:

1. Open a terminal
  * If using OS X press <kbd>command</kbd> + <kbd>space</kbd> and type `terminal` then press <kbd>enter</kbd>
  * If using Windows press the `windows` key and type `git bash` then press <kbd>enter</kbd>
2. In your terminal create a new directory for your project:

Tip: when you see a line like the following that starts with `$`, type everything that comes
after the `$` into your terminal and press <kbd>enter</kbd>.

```
$ mkdir initphp
```


### Setup environment


#### Virtual Machine

When developing it's a good idea to use a virtual machine. This allows you to:

* Separate each project you work on, so that they don't interfere with each other
* Have a dev environment that closely mirrors production (same OS, same package versions, etc)
* Destroy and re-create the entire enviroment quickly, incase you break it or clog it with dev shit

Virtualbox is a virtual machine provider, it allows you to run a virtual machine inside your computer.
Vagrant is a tool which works with Virtualbox to make it easier to create and configure virtual machines.
We're going to use Ubuntu 16.04 as our operating system.

We need to create a `Vagrantfile` in your current directory. This file stores the configuration for your
virtual machine. Put the following in your `Vagrantfile`

```
Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/xenial64"

  config.vm.network "forwarded_port", guest: 80, host: 8080

  config.vm.synced_folder ".", "/srv/www/initphp"

  config.vm.provider "virtualbox" do |vb|
    vb.name = "init-php" # The name of the virtual machine in Virtualbox
    vb.gui = false # Make this true to open up the virtual machine GUI
  
    vb.memory = "1024" # Set the virtual machine to use 1GB of RAM
  end
end
```

Now we can start our VM by doing:

```
$ vagrant up
```

Because this is the first time we're starting the VM, it will take a while to set itself up. But after
this, it should start up in less than a couple minutes.

Once the machine has finished booting, we can SSH into it and move to the directory our project is in:

```
$ vagrant ssh
$ cd /srv/www/initphp
```

Now we're ready to configure it to run a PHP application.


##### Disabling Apache

The base Ubuntu machine that we're using comes with the Apache webserver by default. Since we're going
to be using Nginx, we need to disable Apache:

```
$ sudo systemctl stop apache2
$ sudo systemctl disable apache2
```


#### Installing PHP

We want to use PHP 7.1 because that's the latest, run the following steps while you're SSH'd into the
VM:

```
$ sudo add-apt-repository ppa:ondrej/php
$ sudo apt-get update
$ sudo apt-get install php7.1
```

This will tell Ubuntu where to download PHP from, then to update it's index so that it can download PHP,
then it will install PHP 7.1.

PHP comes with a bunch of stuff inbuilt, but it also has extensions which you can enable to give it some
more functionality. We're going to add an extension so that PHP playes nicely with Nginx (our webserver).

```
$ sudo apt-get install php7.1-fpm
```

#### Turning PHP errors on

By default PHP won't display errors because you don't want them to show
in production. This isn't very helpful in dev so we're going to turn them on:

```
$ sudo vim /etc/php/7.1/fpm/php.ini
```

Now type `/^error_reporting` and hit <kbd>enter</kbd>, this will search for error_reporting
and bring you to the correct line. Now press <kbd>i</kbd> to go into insert mode, and make
the line look like this:

```
error_reporting = E_ALL
```

Press `esc` to go back to normal mode, then `/^display_errors` and <kbd>enter</kbd>.
Now go into insert mode again and make the line look like:

```
display_errors = On
```

Press `esc` then `/^display_startup_errors` then <kbd>enter</kbd>. And make the line look like:

```
display_startup_errors = On
```

Press `esc` then `/^log_errors` then <kbd>enter</kbd> and make the line look like:

```
log_errors = On
```

Press `esc` then `/^html_errors` then <kbd>enter</kbd>, and make the line look like:

```
html_errors = On
```

Now we're done. Press `esc` then `:wq` and <kbd>enter</kbd>. Now we restart php-fpm
to make it reload our changes:

```
$ sudo systemctl restart php7.1-fpm
```


#### Installing Nginx

PHP can't serve web requests directly, so we need a webserver. The webserver is what the user connects
to when they request our website. Nginx will then try to find the file the user is requesting, and do
one of two things with it:

1. If the file is a static file (image, javascript, css, etc)
    it will send the file back to the sure directly
2. If the file is a PHP file
    it will send the file to PHP which will execute the file and send it back to Nginx.
    Nginx will then send the PHP output back to the user.

To make nginx behave this way, we need to configure it, but first, we need to install it and create a
webroot for it to server files from:

```
$ sudo apt-get install nginx
$ mkdir /srv/www/initphp/public
```

At this point we should be able to go to http://localhost:8080 and see the default web page.


##### Configuring Nginx

To create our Nginx config we're going to use the Vim text editor:

```
$ sudo vim /etc/nginx/site-available/initphp
```

Now that we're in Vim, we need to press <kbd>i</kbd> to get into insert mode, this allows you to type text like
any other normal text editor. Then you can copy the config below and paste it into Vim using:

* <kbd>ctrl</kbd> + <kbd>shift</kbd> + <kbd>v</kbd> if you're using Windows
* <kbd>command</kbd> + <kbd>shift</kbd> + <kbd>v</kbd> if you're using OS X

```
server {
        listen 80; # Listen on port 80
        server_name initphp;
        root /srv/www/initphp/public; # Where to look for files to serve
        index index.php;

        location / {
                # Return the file the user is requesting, or index.php by default
                try_files $uri $uri/ index.php =404;

        }

        # If the user is requesting index.php, api.php or form.php, send it to PHP for processing
        location ~ ^/(index|api|form)\.php(/|$) {
                fastcgi_split_path_info ^(.+\.php)(/.*)$;
                include fastcgi_params;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                send_timeout 1800;
                fastcgi_read_timeout 1800;
                fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
        }
}
```

To save the file, we need to exit normal mode by pressing `esc`, then you can type `:wq` and hit <kbd>enter</kbd>.

Now we have our configuration, we need to enable our initphp site, and disable the default nginx one:

```
$ sudo ln -s /etc/nginx/sites-available/initphp /etc/nginx/sites-enabled/initphp
$ sudo rm /etc/nginx/sites-enabled/default
```

Then we can test our Nginx config:

```
$ sudo nginx -t
```

If we don't see any errors, we can restart Nginx to use our new config:

```
$ sudo systemctl restart nginx
```

Now if you go to http://localhost:8080 you'll see `file not found`, because we haven't got anything in
our public directory yet!



## Start the project

From now on, make sure you're in your project directory:

```
$ cd /srv/www/initphp
```


### Setup Composer

Composer is a package manager for PHP, we're going to use it to configure our PHP project. You can
download it from [here](https://getcomposer.org/download/), just copy pase the commands it gives you
into your terminal and you'll get a `composer.phar` file in your current directory.

Now we can initialise Composer for our project, it will ask us a few questions but the default 
values are usually fine so you can just hit <kbd>enter</kbd> a few times.

```
$ php composer.phar init
```

