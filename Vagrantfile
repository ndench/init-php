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
