# wordpress-plugin
The embedding plugin for Wordpress

Install Subversion (SVN)

brew install subversion

Checkout the repo from WP:
svn co https://plugins.svn.wordpress.org/x-ai-calendar-embed

Credentials are in LastPass under Shared - Growth folder.

Add the Trunk files (and assets if you are updating assets)
svn add trunk/*

Update the readme.txt file in /trunk to reflect changes and version number.

Make ALL of your changes then check it back in:
svn ci -m "Update to 1.1"   

NOTE:
Make all of your changes before updating, Wordpress commits set the changes live instantly!
