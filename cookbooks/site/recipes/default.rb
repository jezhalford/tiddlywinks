execute "disable-default-site" do
  command "a2dissite default"
end

web_app "site" do
  application_name "site-app"
  docroot "/vagrant/public"
end
