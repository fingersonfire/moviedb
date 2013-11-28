================================================================================ 
CHANGELOG
================================================================================

v2.0
	* New theme which is HTML5 compatible.
	* Updated code to PHP5.3.
	* Updated to the latest imdbphp2 class (v2.1.0).
	* Revisited database model and increased database fields.
	* Multiple languages introduced.
	
v1.2
	* Updated to the latest imdbphp2 class (v1.9.9).
	* Fixed apple trailer library (www.apple.com -> trailers.apple.com).
	* Empty movie formats are no longer allowed.
	* 'Score' changed into 'Rating' at the movie update page.

v1.1
	* IMDb plot text broken. Fixed by upgrading to imdbphp2 (pre-release 1.9.8).
	* Searching for cover link fixed when adding new movie.
	
v1.0
	* Add a link to an (Apple) trailer (http://sourceforge.net/tracker/?func=detail&aid=2057794&group_id=210311&atid=1013227).
	* YouTube link added to the movie details.
	* By default, the guest login is set to false.
	* Updated to the latest imdbphp class (v1.1.4).
	* Search also supports year.
	* Some graphical restyling.
	* Sorting by loaned out.
	* Default 30 movies per page.
	* Supports customizable movie formats.
	* Movie, audio and subtitles added to movie information (http://sourceforge.net/tracker/?func=detail&aid=2398324&group_id=210311&atid=1013227).
	* Export to CSV (http://sourceforge.net/tracker/?func=detail&aid=2784384&group_id=210311&atid=1013227).
	* FIX: IMDb movie information is downloaded with correct characters and stored as UTF-8 text.
	
v0.2
    * php4dvd can be installed or upgraded with the web installer.
    * More information is added to the movie: format, personal notes, if you 
      have seen it, if you own it and if you loaned it out.
    * Sort by drop down box to sort by more criteria.
    * Added paging, so you can select how many movies you want to view per page
      to speed up the site.
    * Added user login with guest, editor and admin users.
    * Your search is saved, so when going back to the search page, the same 
      search results appear.
    * Code split up into include files for easier development.
    * Added delete button when showing movie information.
    * Updated to the latest imdbphp class (v1.0.3)
    * Fixed the check for JPG covers only, any other format is not supported.
    * When downloading the cover, the file generated will get the name of the 
      movie instead of the id of the movie.
    * Added path of the movie images and covers to the config. This location can
      be adjusted.
    * Removed double plotline from the movie overview.
    * Loading screen when building the list of movies.
      
v0.1
    * Initial release, including ajax search, sorting by name and year, adding
      movies, searching on IMDb, searching for covers, adding covers.

================================================================================ 
ABOUT php4dvd
================================================================================

php4dvd is a small yet powerful, php/mysql powered movie data base.
features:

    * Search IMDb.com for movie information
    * and store this detailed information (like directors, actors, poster, language...)
    * More information per movie like personal notes, if you own or have seen the movie, loaned it out, etc...
    * Add covers to your movies
    * Powerful and quick search function
    * User login
    * Multiple languages
    * Very configurable, easy to use
    * Layout is based on a template which you can easily adjust

for more information, see: http://php4dvd.sourceforge.net/

================================================================================ 
LICENSE
================================================================================

    This file is part of php4dvd.

    php4dvd is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    php4dvd is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with php4dvd. If not, see <http://www.gnu.org/licenses/>.

================================================================================
REQUIREMENTS
================================================================================

    To use these files you need to have a php installation:
    - Apache 2
    - Php 5.3
    - GD2 library to be able to upload (and resize) covers
      (to check if you have gd2 available, open phpinfo.php)
    - MySQL 5.0

================================================================================
INSTALLATION/UPGRADE
================================================================================
    1. Upload all the files to your website (and overwrite existing files) 
       (ex. http://www.yoursite.com/php4dvd).
    2. Open the website and the installer will show up.
    3. Follow installer steps.
    4. Manually remove the install/ directory.
    5. Log into php4dvd using the username: admin, password: admin.
    
================================================================================
CONFIGURATION
================================================================================
    
    * Php
    Read the INSTALLATION/UPGRADE information above to read the explanation how
    to install and which variables can be adjusted. When you want to adjust the
    configuration, open config/config.php and adjust the variables. The default
    configuration file is located at confg/config.default.php.
    By default, guest users can view your move collection, but are not allowed
    to change the movie collection. If you don't want guest users to view your
    collection, set the 'guestview' variable to false in config/config.php after
    installation or upgrade.
    
    * GD2
    In order to to be able to upload and resize covers, you need the GD2 
    library. Check if 'gd' is available by opening phpinfo.php
    
    * Access
    Try to run the website, but if the site failes opening with a 'Internal 
    Server Error', adjust the .htaccess file in the root of the site.
    Try to remove the Options line by placing a # at the beginning of the line.
    Otherwise remove the <Files> section. These settings might fail because of
    the permissions of your webserver.
    
================================================================================
TEMPLATES
================================================================================

    This site can be customized by adding your own template. Take a look at the
    tpl/default/ directory and copy this directory to your own tpl directory.
    Now you can adjust the config/config.php to your template. Check all 
    template files and try to adjust them to your own whishes. 
    If you only want to adjust some colors, open the 
    tpl/<template_dir>/css/style.css and style_ie.css to adjust the css of the
    site.
    
================================================================================
THANKS TO
================================================================================

    Thanks to morphias0. He wrote the first automatic installer/upgrade script 
	and came up with some extra features. If you want to request more features, 
	visit http://sourceforge.net/tracker/?group_id=210311.
     
    Thanks to Izzy from IzzySoft. He wrote the imdb php class to be able to 
    search for movies at IMDb.com. For more information see:
    http://projects.izzysoft.de/trac/imdbphp
    