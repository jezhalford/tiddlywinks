#
# Cookbook Name:: chef-php-extra
# Recipe:: module_memcached
# Added by Jez
#

include_recipe "chef-php-extra"

if node['php']['ius'] == "5.4"
      packages = %w{ php54-memcached }
elsif node['php']['ius'] == "5.3"
      packages = %w{ php53u-memcached }
else
      packages = %w{ php-memcached }
end

pkgs = value_for_platform(
  [ "centos", "redhat", "fedora", "amazon", "scientific" ] => {
    "default" => packages
  },
  [ "debian", "ubuntu" ] => {
    "default" => %w{ php5-memcached }
  }
)

pkgs.each do |pkg|
  package pkg do
    action :install
  end
end
