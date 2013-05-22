Vagrant.configure("2") do |config|

  config.vm.box = "precise64"

  config.vm.box_url = "http://files.vagrantup.com/precise64.box"

  config.vm.network :forwarded_port, guest: 80, host: 8080

  config.vm.synced_folder ".", "/vagrant", :extra => 'dmode=777,fmode=777'

  config.vm.provision :chef_solo do |chef|

    chef.json = {
        :mysql => {
            :server_root_password => "password",
            :server_repl_password => "password",
            :server_debian_password => "password"
        }
    }
    chef.cookbooks_path = "cookbooks"
    chef.add_recipe("apt")
    chef.add_recipe("apache2")
    chef.add_recipe("mysql::server")
    chef.add_recipe("php")
    chef.add_recipe("php::module_apc")
    chef.add_recipe("php::module_memcache")
    chef.add_recipe("php::module_mysql")
    chef.add_recipe("php::module_curl")
    chef.add_recipe("memcached")
    chef.add_recipe("apache2::mod_php5")
    chef.add_recipe("apache2::mod_rewrite")
    chef.add_recipe("site")
  end
end
