=== Memphis Documents Library ===
Contributors: bhaldie
Donate link: http://www.kingofnothing.net/
Tags: plugin,documents,memphis,bhaldie,WordPress,library,repository,files,versions, import, export,document management, file management, customer file manager, distribution, document management, document manager, enterprise document control, file manager, file sharing, file uploads, Retrieval & storage, versioning
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 3.5
Tested up to: 4.8
Stable tag: 3.7.2.2

A documents library for WordPress.

== Description ==

Memphis Documents Library (mDocs) is a  documents library for WordPress with a robust feature set.  It is a great tool for the organization and distribution of files.

= What's New With Version 3.7.2.2 =

* *Bug* - Remove alert in javascript.

= Memphis Documents Library Features =

* Document preview and thumbnails available for most file types.
* Batch Upload of files into the system
* Upload media files that match WordPress's white-list. This white-list is configurable from the WordPress menus.
* Download tracking of files
* Posts created for each new media upload, showing information of the specific file.
* Version control, allows you to view and revise to older version of your file.
* The ability to share you files on other websites.
* Social media buttons for each document.
* Referential file methodology. This allows for the updating of a file while the link remains the same.
* Importing of document libraries into your current library, or just migrating to another website.
* Exporting you documents libraries for safe backup and store, migration to another website or sharing with someone else.
* The ability to create, edit and delete categories and subcategories.
* Search for files using the WordPress search.
* Customization of download button

== Feature Requests ==

* Feature - Have the ability to define sort options per folder.
* Feature - Add max file size configuration settings.
* Feature - Shrink and expand folders.
* Feature -  Shortcode take parameters to be able to hide version/last mod/etc.
* Feature - Apply a hierarchical structure to files in the folder.
* Feature - One file added into multiple folders. 
* Feature - Have the ability to comment on documents and have the owner notified what changes need to be made to the file.
* Feature - Change the font size of the folders or have them in a gallery like format.
* Feature - Have a shortcode to display all files by tag.
* Feature - Add a print button.
* Feature - Have the ability to create a custom sort order.
* Feature - Custom input fields.
* Feature - Restrict file download by user or role.
* Feature - Allow a role type to mange all files.
* Feature - Permissions in folders instead of each document independently.
* Feature - Add the ability to add a link back to the mDocs documents list.
* Feature - Added more level to categories.
* Feature - Add the ability to change the path name and breadcrumb name.
* Feature - Add the ability to add files from the front-end.
* Feature - Exposing filepath for indexing website via ElasticSearch.
* Feature - Prettified HTML preview.
* Feature - Add hover colour configuration to the navbar background on hover.
* Feature - Add folder structure to the mdocs post page.
* Feature - Password protected files.
* Feature - have a button that will add shortcode directly in editing posts.
* Feature - Allow other users access to mDocs admin menus.
* Feature - Have the post open in a modal instead of going to the page directly.
* Feature - Have a in application pdf preview.

== Frequently Asked Questions ==

= Box View Closes New Account Creation =

Unfortunately it has come to my attention the Box no longer allowing the creation of Box View applications keys.  This means that new users to mDocs will not be able to use the Box Viewer as an alternative to Google.  I am looking at alternatives but currently there is no solution.

= Add Page Templates to Memphis Documents Library =

To add templates to custom posts you will need to download a plugin "Custom Post Type Page Template".  This will allow you to add templates to any custom post including mdocs posts.  Here is the link to the plugin: https://wordpress.org/plugins/custom-post-type-page-template/

= Non Member Can't Download =

If you are getting an issue with non member not being able to download files try this fix.

* Go to the Dashboard > Memphis Docs Tab
* Check the check box beside the Name label of the table
* Click on the Batch Edit button
* Check the NM check boxes for every file
* Save you work
* Sign out of WordPress and then try to see if you can now download the file.

= Preview not Working =

First thing to try is go to Setting > Disable Third Party Includes: > Bootstrap and check the check box.  Try the preview again.  If that doesn't work the second most like issue is your themes css if conflicting with mDocs functionality.  The second problem is hard to fix it requires you to debug you site and check and change values in order to get the preview to show.  If you need assistance on the css to edit please feel free to contact me.

Another issue with preview is with Google docs viewer which is Memphis Docs default viewer.  I have noticed lately that the preview will not load sometime if a refresh the page it seems to solve the problem but is not really a solution.  The only solution that I have found is to change to the Box previewer.  I have an not issue with this previewer and works every time.

= 404 Error when trying to access document page =

If you get a 404 error when trying to access your Memphis documents pages try going to Setting>Permalinks and pressing Save.  This may solve the issue, if it doesn't please contact me for more support.

= Memphis Documents Library look wrong in IE =

Add the following code to your theme right under the `<head>` tag this will turn off compatibility mode for IE.
`<meta http-equiv="X-UA-Compatible" content="IE=11; IE=10; IE=9; IE=8; IE=7; IE=EDGE" />`

= Importing Into Memphis Documents Library =

There are two type of imports you can choose from.

**Keep Existing Saved Variables**

* Is the safest way to import.  This option keeps all your current files and only imports new ones. 
If a file that is being imported matches one on the current system, the one on the current system will be left untouched,
and you will have to manually import these files.

**Overwrite Saved Variables**

* Is a good when you have a empty documents library or you at looking to refresh your current library.  
This method deletes all files, posted and version on the current system. After the method has completed you will
get a list of all the conflicts that have occurred make note of them.
Please take great care in using this method as there is little to no return.

= Exporting Out of Memphis Documents Library =

When you click the export button the document library will create a ZIP files for you to save to your computer.
This compressed data, will contain your documents, saved variables, media and posts tied to each document.
Once you've saved the download file, you can use the Import function in another WordPress installation to import the content from this site.

= Uninstalling Memphis Documents Library =

When you uninstall the documents library make sure you export all your important files. **All data will be removed on completion of uninstall, this includes files, directories, posts, and media.**

== Installation ==

From the WordPress plugin menu click on Add New and search for Memphis Documents Library

Instead of searching for a plugin you can directly upload the plugin zip file by clicking on Upload:

Use the browse button to select the plugin zip file that was downloaded, then click on Install Now. The plugin will be uploaded to your blog and installed. It can then be activated.

Once uploaded the configuration menu is located in either the "Memphis" menu with the heading of "Documents" in the Dashboard or in the "Memphis Docs" menu. 

== Screenshots ==

1. screenshot-1.png 
2. screenshot-2.png
3. screenshot-3.png
4. screenshot-4.png
5. screenshot-5.png
6. screenshot-6.png
7. screenshot-7.png
8. screenshot-8.png

== Changelog ==

= 3.7.2.2 =

* *Bug* - Remove alert in javascript.

= 3.7.2.1 =

* *Bug* - Fixed html issue.
* *Bug* - Fixed user rights issue.

= 3.7.2 =

* *New* - Added an author and description to the list of items in the file list table.
* *Update* - Change of function name get_the_mdoc_by to mdocs_get_file_by.
* *Update* - Minor modifications to the social functions.
* *Update* - Changed get attribute from att to mdocs-att.
* *Bug* - Fixed php version issues.
* *Bug* - Security updates.

= 3.7.1 =

* *New* - Add the ability to added WordPress categories to your mDocs posts.
* *New* - Added a FTP batch upload.
* *New* - Export has option to manually delete system temp directory export file.
* *Update* - Minor improvements to the import feature.
* *Update* - More changes to how session data is handled.
* *Update* - Changes to date time functionality.
* *Update* - Removed function mdocs_get_inline_admin_css.
* *Update* - Removed output check.
* *Update* - Security update.
* *Bug* - Fixed issue with search functionality.

= 3.7 =

* *New* - Added a session check.
* *Update* - Removed redundant file.
* *Bug* - Added a catch for no file extension when importing.
* *Bug* - Security fixes.

= 3.6.23 =

* *New* - Test with version 4.8.
* *New* - Added mDocs id information to preview iframe.
* *Update* - Added a function check for session_status.
* *Update* - When adding a file type any "." will be removed, also the file extension will be converted to lowercase.
* *Bug* - fixed issue with import and file extension that are capitalized.
* *Bug* - Fixed issue with TinyMCE not showing certain buttons like bullet list.

= 3.6.22 =

* *New* - Added new file type tif
* *New* - Remove the title from all mdocs widgets.
* *New* - Added woocommerce support.
* *Update* - All file extension will be converted to lowercase for icon check function is run.
* *Update* - Font Awesome will now be disabled in the dashboard when disabled from the setting menu.
* *Update* - Added localization text for widget titles.
* *Update* - Made some minor changes to how update to revision works.
* *Update* - Added .mdocs-tooltip .btn-group { font-size:inherit !important;} to mDocs stylesheet.
* *Bug* - More security fixes.

= 3.6.21 =

* *New* - Added a new sanitize function check sanitizing strings.
* *Update* - Updated widgets to be compatible with PHP 7+.
* *Update* - Updated the way sanitation for arrays are handled.
* *Update* - Removed unwanted link information from the share modal.
* *Update* - Changed the way sessions are handle.
* *Update* - Added an ignore if user doesn't exists when importing files.

= 3.6.20 =

* *Update* - Changed how description finds mdocs id.
* *Update* - Added a function check for the tooltip() function in the dashboard.
* *Update* - Removed class small from Memphis css.
* *Bug* - Fixed issue with Firefox and space characters in a file name.

= 3.6.19 =

* *Update* - File names will no longer be aloud to use commas.
* *Update* - New image and pdf uploads will no longer create thumbnail images.
* *Bug* - Fixed issue with import and the addition of posts and media items.

= 3.6.18 =

* *Bug* - Added a missing comma to a substr function thanks @codeward
* *Bug* - Fixed issue with mdocs dashboard not displaying the proper folder link.

= 3.6.17 =

* *New* - Can set the Goto Post link to open in new tab or not set.
* *New* - Added version to the advance search functionality.
* *Update* - Change the way mdocs loads its headers.
* *Bug* - Fixed issue with the loading of bootstrap tooltip and some sites.

= 3.6.16 =

* *Update* - Moved the when the modals get loaded.  Now are loaded when wp_head fires.
* *Bug* - Fixed issue with the hook post type and loading of mdocs scripts.
* *Bug* - Fixed issue with tabs not working.
* *Bug* - Fixed issue with description thumbnail of images not displaying.
* *Bug* - Fixed issue with bootstrap not loading on mdocs post page.
* *Bug* - Fixed issue with advanced search functionality.
* *Bug* - Fixed issue with the display of contributors in the Manage File menu.

= 3.6.15.1 =

* *Bug* - Fixed issue with an uncaught error.

= 3.6.15 =

* *Feature* - When using WordPress search, file name, name and owner will now find matching results.
* *Feature* - Added icons to files to show owners and administrators what the status of the file and post is.
* *Bug* - Fixed issue with grid view of media module showing mdocs media.
* *Bug* - Cleaned up links in widgets.

= 3.6.14 =

* *Feature* - Added a new short code for showing one file on any post, page or widget.
* *Update* - minor style change to file type icons.
* *Update* - Cleaned up permalink for go to post.
* *Bug* - Fixed issue with import making every post a draft.
* *Bug* - Fixed issue with mime types.
* *Bug* - Fixed issue with widgets not sorting properly.

= 3.6.13 =

* *Feature* - Added an error code output for zip errors.
* *Feature* - Removed some unneeded data in the mdocs-post.
* *Update* - Tested with version 4.7.
* *Update* - Changed style of more admin modules.
* *Bug* - Fixed an issue with the correct date and time when viewing versions.

= 3.6.12 =

* *Feature* - Add a robust "Unauthorized to download file" page.
* *Update* - Changes some admin screen styles.
* *Update* - Removed extra slashes from mdocs file title.

= 3.6.11 =

* *Feature* -  Added contributor adding and removal from the batch edit tool.
* *Feature* - Added a new server compatibility check to see if the systems temp directory is available to php.
* *Update* - Changed error messaging in batch upload module.
* *Update* - Changed the layout of the batch upload module.
* *Bug* - Language fixes.
* *Bug* - Fixed issue with disabling non members checkbox, causing documents to be not downloadable from non members by default.

= 3.6.10 =

* *Bug* - Language fixes.
* *Bug* - Fixed issue with contributors.
* *Bug* - Fixed style problem with contributor editor.

= 3.6.9 =

* *Feature* - Unfortunately it has come to my attention the Box is no longer allowing the creation of Box View applications keys.  This means that new users to mDocs will not be able to use the Box Viewer as an alternative to Google.  I am looking at alternatives but currently there is no solution.
* *Bug* - Fixed issue with download button and logged in users.

= 3.6.8 =

* *Bug* - Fixed download issue with non members.

= 3.6.7 =

* *Update* - Now fully with WordPress Translate.  There is currently one translation complete and one in progress.  Thanks to @gsavix for the Brazil translation and @hyrules for both french translations.
* *Update* - Added a safe guard if you disable bootstrap in the dashboard, the setting menu will be added as a sub menu to the Memphis Docs tab.
* *Update* - Style clean up and refinement.

= 3.6.6 =

* *Feature* - Added the ability to turn off bootstrap in the dashboard.
* *Update* - changed the css to add a cursor pointer to the sort text buttons.
* *Bug* - Fixed issue with permalinks and the sort buttons, not displaying the right page.

= 3.6.5 =

* *New* - Added a new setting, converts Cyrillic, European and Georgian characters in file names to Latin characters.
* *Update* - Remove widget style, now it is up to the users theme to determine what the widgets style is.
* *Bug* - Fixed capital letter bug.
* *Bug* - Fixed file names with spaces bug.
* *Bug* - Fixed accent bug.

= 3.6.4 =

* *Update* - Changed the folder structure to more of a traditional folder layout.  Also removed the setting to show current folder on top.
* *Update* - Minor codes clean up and changes.
* *Fix* - Fixed bug with the WPSOR plugin.
* *Fix* - Fixed issue with TinyMce editor.

= 3.6.3 =

* *Update* - Changed the way post are handled if they have been deleted by a user.
* *Bug* - Fixed issue when deleting a previous version of the file.
* *Bug* - Fixed issue with the hiding of file attributes

= 3.6.2 =

* *Fix* - Removed the donate button from WordPress pages.

= 3.6.1 =

* *New* - From setting menu can choose to hide the name of the file or the file name.  You can not hide both if you select both only the file name will show.
* *Update* - Changed the way a file's version auto updates.
* *Update* - Renamed a function from parse_size to mdocs_parse_size.
* *Update* - Change the location of batch edit, batch move and batch delete.
* *Bug* - Fixed issue with privacy settings.
* *Bug* - Fixed issue with updating a file.

= 3.6 =

* *New* - Added a download button to the list of files
* *Update* - File will now retain there name upon upload, the only exceptions will be if the file name already exists.
* *Update* - Reorganized the setting page.
* *Update* - Removed the new and updated badge on the file list and replaced it with a green background color or new and and blue background color for updated.
* *Update* - By default file type icons are now disabled.  You can go to the setting page to re enable them.
* *Update* - Changed the way files are cleaned up after a mdocs process is run.
* *Update* - Small update to the mdocs style-sheet.
* *Update* - Updated the way a version file checks to see if it can be downloaded.
* *Update* - Updated font awesome link.
* *Update* - The new and updated label is now hidden by default, you can enable the label from the settings under Configuration Settings> UI Options > Hide New and Updated Label
* *Bug* - Removed a variable dump from the previous version.
* *Bug* - Fixed bug the caused files to disappear after opening them thanks to @norucus for finding this one.

= 3.5.9 =

* *Bug* - Date and time bug fixes.

= 3.5.8 =

* *Update* - Updated some text.
* *Bug* - Made a change on how time is processed.
* *Bug* - Changed a check point message.

= 3.5.7 =

* *Fix* - More 5.6 and lower testing.

= 3.5.6 =

* *Fix* - More 5.6 and lower testing.

= 3.5.5 =

* *Fix* - More 5.6 and lower testing.

= 3.5.4 =

* *New* - PHP support 5.6 and greater.
* *Bug* - Fixed issue with revisions
* *Bug* - Another fix for batch file method bug.

= 3.5.3 =

* *Bug* - Fixed issue with batch file method.

= 3.5.2 =

* *New* - Added a setting to turn off sessions.
* *New* - From the setting menu you can now hide the navbar.
* *New* - From the setting menu you can now hide the sort bar.
* *New* - Added a setting to control the mdocs post title.
* *Update* - Added icon support for pptx files.
* *Update* - System check show the upload dir.
* *Bug* - Fixed issue with session data.
* *Bug* - Fixed a placement of an error message.
* *Bug* - Fixed issue with timezones.
* *Bug* - Fixed issue with temp directory and trying to delete full folder.

= 3.5.1 =

* *Update* - Removed some debugging code.

= 3.5 =

* Fixed issue with batch upload
* Tested up to version 4.6.1
* other small bug fixes and updates.

= 3.4.6 =

* *Bug* - Fixed folder issue.
* *Bug* - Fixed issue with image preview.
* *Bug* - Minor bug fixes.

= 3.4.5 =

* *Update* - Removed some legacy css.
* *Bug* - Fixed issue with tinymce.
* *Bug* - Fixed issue with folders.

= 3.4.4 =

* *Bug* - Fixed issue with sub folder not displaying the right parent folder.
* *Bug* - Added the nav menu back to the setting page, was removed by mistake.

= 3.4.3 =

* *Update* - Changed file structure.
* *Update* - Changed the way options were being set.

= 3.4.2 =

* *Feature* - From the settings menu you can now turn off the file type icons.
* *Update* - Code cleanup.
* *Bug* - Fixed issue with a zero index in the ratings system.
* *Bug* - Fixed issue with description removing line breaks.

= 3.4.1 =

* *Feature* - By default all Memphis Documents are hidden in the Media Dashboard.  You have the ability to show them from the Settings menu under Hide Things.
* *Feature* - Added a new server compatibility check, this check that a server has sessions enabled.
* *Update* - Tested up to 4.5.2
* *Update* - Changed some style settings.
* *Update* - Rating a file can only be done by logged in users.
* *Update* - Streamlined the preview/description code.
* *Update* - Added new function get_the_mdoc_by, which which will remove redundant functions.
* *Update* - Move some settings around, for a more uniform layout.
* *Update* - Added closing div tags to the mdocs navbar.
* *Bug* - Defined an undefined variable.
* *Bug* - Fixed issue with viewing of private files.

= 3.4 =

* *Update* - Changed the right and permissions methodology.
* *Update* - Bootstrap style updates.
* *Fix* - Fixed issue with Site Origin plugin and Memphis Documents Library.
* *Fix* - Fixed issue with contributors and downloading of files.
* *Fix* - Fixed issue when added contributors.
* *Fix* - Fixed issue with iris color pickers.

= 3.3.4 =

* *Update* - Localization language updates.
* *Update* - Changed to the way batch file options are display.  Now are hidden by default.
* *Update* - Changed the look of the Server Compatibility Check administration page.
* *Update* - Changed the look of the Short Codes administration page.
* *Update* - Changed the look of the Find Lost Files administration page.
* *Update* - Minor updates and fixes.
* *Update* - Deleted unused file.
* *Fix* - Fixed and issue where users that were not logged in could not see the preview button.

= 3.3.3 =

* *Fix* - Minor bug fixes and improvements.

= 3.3.2 =

* *New* - Added improved localization support.
* *New* - Added the ability to hide upload settings. [megecookie]
* *New* - Added the ability to show current folder on top of document list [megacookie]
* *Update* - NL translation updated [ megacookie ]
* *Fix* - Fixed issue with the loading of the javascript for Color picker
* *Fix* - Other small bug fixes 

= 3.3.1 =

* *New* - Added the ability to change the navbar background color and text color from the Setting menu.
* *Update* - Style updates.
* *Fixes* - Bootstrap drop down button.
* *Fixes* - Minor bug fixes and updates.

= 3.3 =

* *New* - Batch file management.
* *New* - Now you can set an future dates on all files and post just by changing the date to a future one.
* *New* - Added an new server compatibility check.
* *New* - Added the ability to download older versions of files.
* *Update* - Changed when file is updated, now will only update when a new file has been uploaded.
* *Update* - Condensed bootstrap to fix a lot of style issue with many users.  This should fix a lot of style issues.
* *Fix* - Fixed issue with Google preview counting as download.
* *Fix* - Fix issue with preview was showing in drop down menu when it was disabled in settings.
* *Fix* - Fixed issue with File System Cleanup.
* *Fix* - Fixed issue with version deletion.
* *Fix* - Minor bug fixes and updates.

= 3.2.1 =

* *Fix* - Fixed issue with downloads not registering.

= 3.2 =

* *Update* - Update to the localization files. 
* *Fix* - Minor bug fixes

= 3.1.6 =

* *Fix* - Removed method to destroy session, too many users with session issues.
* *Fix* - Security fix.

= 3.1.5 =

* *Fix* - Changed method to destroy session.
* *Fix* - Fixed an issue with Google docs preview.

= 3.1.4 =

* *New* - Added another setting for drop down menu issue using bootstrap.
* *New* - Added a new setting to hide a mDocs post from the main page.
* *New* - Added a destroy session on log-in or log-out.
* *Update* - Changed the displayed output of the preview windows, made the preview window bigger.
* *Update* - Changed the way a session is initialized.

= 3.1.3 =

* *Update* - Remove bot checking.
* *Bug* - Fixed issue with the go to post button.
* *Bug* - Added a fix for Twenty Sixteen theme.
* *Bug* - Fixed bug prevented Box View updater to run.

= 3.1.2 =

* *Bug* - Fixed bug prevented Box View updater to run.

= 3.1.1 =

* *New* - Now you have the choice to use Google Document Preview or Box View.
* *Update* - Removed a redundant css file.
* *Bug* - Fixed Page Builder bug.

= 3.1 =

* *New* - Added thumbnail image for PDFs using Imagick.
* *Update* - Removed Box view and reverted back to Google doc view.
* *Update* - Added another server compatibility check, to see if WordPress upload directory is accessible.
* *Update* - Added another server compatibility check, to test if ZipArchive is installed.
* *Update* - Added another server compatibility check, to see if Imagick is installed.
* *Update* - Minor changes and updates.
* *Bug* - Fixed localization bug which didn't allow uploading files when using translations.

= 3.0.18 =

* *Update* - Tested up to version 4.4.
* *Bug* - Data check added, to fix minor issue with contributors.
* *Bug* - Fixed capitalization bug when using import from one system to another.

= 3.0.17 =

* *Update* - Changed the color of the 'Add Main Folder' Button.
* *Bug* - More fixes to folder issues
* *Bug* - Minor bug fixes.

= 3.0.16 =

* *New* - Fontawesome can now be turn off as a third party applications.
* *Bug* - More fixes to folder navigation.
* *Bug* - Changes made to file management.

= 3.0.15 =

* *New* - There is a new setting that will allow you to disable Memphis Documents Library's third party applications.
* *New* - Added Cyrillic to Latin file name conversion, this convert Cyrillic to a Latin format.
* *New* - Added a setting to turn off the "No files found in this folder." statement.
* *Bug* - Changes some code around to try and address the folder linking issues.

= 3.0.14 =

* *Update* - Removed some debugging code.

= 3.0.13 =

* *Update* - Change the way modals open, now using pure java script.
* *Bug* - Fixed a bug when adding and removing folders.
* *Bug* - Small fix to the batch uploader.
* *Bug* - Fixed issue with contributors not being adding when uploading a new document.
* *Bug* - Fixed some permission issues.

= 3.0.12 =

* *New* - Added an new test to server compatibility
* *Bug* - Fixed Fatal error issue dealing with date method.
* *Bug* - Fixed naming issue using batch upload.
* *Bug* - Fixed folder issue when using short code and having multiple short codes on one page.

= 3.0.11 =

* *New* - Added a server compatibility module, to see if you have all required elements for mDocs to work properly.
* *Bug* - More fixes to import and export.
* *Bug* - Minor fixes to the social media buttons.
* *Bug* - Fixed date issue.

= 3.0.10 =

* *Bug* - File size bug fix.
* *Bug* - Improvements to the import export processes.

= 3.0.9 =

* *New* - Now can disable the ability for users to sort documents
* *New* - A setting is available to have the mDocs Posts visible from the dashboard.
* *Update* - Now can run Preview and Thumbnail updater at any time.
* *Bug* - Fixed Allowed file types bug.
* *Bug* - Fixed the date issue when adding and updating documents.
* *Bug* - Fixed some style issues.
* *Bug* - Fixed some other small bugs.

= 3.0.8 =

* *Bug* - More fixes to the folder editor.

= 3.0.7 =

* *New* - Added a file finder, to help retrieve lost files.
* *New* - Added a tag editor to the uploaded for new/updated documents.
* *Update* - More changes made to the "mdocs-modals" class style.
* *Update* - Language update.
* *Update* - Small changes to the main style sheets.

= 3.0.6 =

* *Update* - Changed some rights to see certain buttons.
* *Update* - Added a mDocs tag to the body for theme style issue fixes.
* *Update* - Added a class to all modals called "mdocs-modals".

= 3.0.5 =

* *Bug* - Fix to specific drop down menu issue, made by Cameron Barrett
* *Bug* - Fixes to imports and exports.
* *Bug* - Fixes to File System Cleanup
* *Bug* - Fixes to Restore to Defaults

= 3.0.4 =

* *Bug* - More fixes to downloads.
* *Bug* -  fixed settings check boxes for non member downloads and show social apps.

= 3.0.3 =

* *New* - Change the font size of the documents list.
* *New* - Hide/Show sub folders when using short codes.
* *New* - Added to new setting for changing font size and hiding and showing sub folders.
* *Update* - Fixed Bootstrap navbar issue.
* *Update* - Remove some unused Bootstrap functionality.
* *Update* - Added a mDocs class to a Bootstrap drop down menu
* *Update* - Removed unused Jquery UI java script and css
* *Bug* - Fixed php error on rights page.
* *Bug* - Fixed a null session error when uploading a file.

= 3.0.2 =
* *New* - Added a new button for files to refresh document preview
* *Update* - Added a catch for versions that check if file exists.
* *Update* - Added a catch for file upload errors using php 5.3 and higher.
* *Update* - Fixed Box View preview window.
* *Update* - Many other small updates
* *Bug* - Fixed issue when you delete a file then tried to add another file.
* *Bug* - Fixed many other warning and noticed.

= 3.0.1 =
* *Bug* - Fixed, admin menu issue
* *Bug* - Fixed, null reference to 'mdocs-view-private'

= 3.0 =
* *New* - Now other user types can upload files to mDocs, with the ability to add other contributors to the files they own.
* *New* - Look and feel has been updated.
* *New* - Added more safety check for lost of data.
* *New* - Added Finnish language support, thanks to *sloworks* for their hard work.
* *New* - Interface improvements
* *New* - Added a Dutch Translation thanks to DK for all the hard work.
* *New* - Thumbnails of most documents now on the description page of each file.
* *New* - Google Doc View has been replaced with Box Viewer API, this allows for some extra functionality not available with Google Docs.
* *New* - The ability to change the Last Modified category of a file.
* *New* - Added an option in the Settings to change the date format.
* *New* - The ability to allow/deny user types access to Private Posts. 
* *New* - In the setting menu you can now choose the allowed file types.
* *New* - A restore defaults option has been added this will restore Memphis Documents Library to its factory state, *WARNING all files and post will be deleted*.
* *Update* - Updated Font Awesome to version 4.3.0
* *Update* - Updated localization files.
* *Update* - Uninstall will not remove all saved variables , posts, files, categories, and directories for a single WordPress Site and also WordPress Multisite.
* *Update* - Change the way date modified is handle, was using an array value now using file date modified attribute.
* *Update* - Updated localization files.
* *Update* - Change $auto load functionality from yes to no for mdocs-list and mdocs-cats database entries.
* *Update* - Removed the choice of size of list.  Large size document list caused performance issues and had to bee removed.
* *Update* - Added a slug name to the custom post recreating function.
* *Update* - Added the ability to see document previews when logged in.
* *Update* - Changed the Google docs link to Google drive.
* *Bug* - Fixed the XSS (Cross Site Scripting) issues root cause was using $_REQUEST inside a form.
* *Bug* - Fixed the security vulnerabilities known as LFI/RFI, which stands for Local or Remote File Inclusion.
* *Bug* - Fixed mime type bug, where mime types where not being removed properly.
* *Bug* - Fixed issue with post always showing mDocs at the top of the post.  Now it behaves as expected.
* *Bug* - Fixed bug which didn't allow for viewing sub categories when using mdocs short codes.  This short code currently only works on main categories you can't target a subcategory to display.
* *Bug* - Fixed security issues using $_REQUEST inside a form.
* *Bug* - Fixed security issue Local or Remote File Inclusion.
* *Bug* - Fixed Batch Upload naming issue.
* *Bug* - Added a missing div tag to list.
* *Bug* - Fixed a bug when creating categories a null category would be created that could not be delete.
* *Bug* - Error with java script loading, if using WordPress Multisite network admin.
* *Bug* - Fixed issue where Post Status was not displaying any statuses.
* *Bug* - Batch upload was cutting of file names with dots in them.
* *Bug* - Fixed bug causing new installs to produce errors, these errors would correct themselves but very annoying for users to see.
* *Bug* - Removed extra label tag in sort box which was cause issues in Firefox.
* *Bug* - Fixed, Chrome bug, where file types that are allowed in WordPress are being blocked by Memphis Documents Library.
* *Bug* - Fixed, when there are multiple categories on a page the get request fails to recognize each individual category.
* *Rejected* - Short-code to add a download link to a post or page.
= 2.6.1 =
* *Update* - Change the way date modified is handle, was using an array value now using file date modified attribute.
* *Update* - Updated localization files.
* *Bug* - Fixed Chrome bug, where file types that are allowed in WordPress are being blocked by Memphis Documents Library.
= 2.6 =
* *New* - The ability to allow/deny user types access to Private Posts. 
* *New* - In the setting menu you can now choose the allowed file types.
* *New* - A restore defaults option has been added this will restore Memphis Documents Library to its factory state, *WARNING all files and post will be deleted*.
* *Update* - Updated localization files.
* *Update* - Uninstall will not remove all saved variables , posts, files, categories, and directories for a single WordPress Site and also WordPress Multisite.
* *Bug* - Error with java script loading, if using WordPress Multisite network admin.
* *Bug* - Fixed issue where Post Status was not displaying any statuses.
* *Bug* - Batch upload was cutting of file names with dots in them.
* *Bug* - Fixed bug causing new installs to produce errors, these errors would correct themselves but very annoying for users to see.
* *Bug* - Removed extra label tag in sort box which was cause issues in Firefox.
= 2.5.1.2 =
* *Bug* - Fixed loop bug, when a Memphis Documents post does not have the category mdocs-media.  Now the result will be an output of the short-code only.
* *Bug* - Permalink setting fixed. Sub categories where not working when set to default WordPress permalink setting.
* *Bug* - JavaScript error with FireFox and IE.  A undefined `event.preventDefault();` was causing Add Main Category to no function.  Removing this line fixed the issue.
= 2.5.1.1 =
* *Hot-Fix* - Added the style.css file to the admin page. Now the page will display the correct style.
= 2.5.1 =
* *Fix* - Removed style.php and replaced it with style.css and used the WordPress function `wp_add_inline_style` to handle custom style sheet changes.
* *Fix* - Disabled the ability to view a private post if the user does not have the capabilities to.
* *Fix* - Updated large list to reflect the addition of sub categories.
* *Fix* - Removed unnecessary padding from the category tabs.
* *Update* - Updated localization.
* *Update* - Removed the sub folder on the right side of the documents list, seems unneeded.
= 2.5 =
* *New* - You have the ability to create sub categories.
* *New* - Three new widgets have been added, you can now display, Most Downloaded, Highest Rated and Recently Updated documents.
* *Fix* -  Issue with file upload on Windows platform, now is resolved.  Batch upload still remains in beta.
* *Fix* - Minor style changes
* *Bug* - small bug fixes and updates.
= 2.4.1 =
* fixed short code, not showing categories.
* special character changes.
* lots of bug fixes
* optimization of code
= 2.4 =
* Removed IE Compatibility mode fix, this was causing too many header errors.  If you want to this functionality add this line to your theme header file, right under the `<head>` tag
 * `<meta http-equiv="X-UA-Compatible" content="IE=11; IE=10; IE=9; IE=8; IE=7; IE=EDGE" />`
* Add the ability to change the color of the download button.
* Fixed the rss feed bug
* Fixed a look an feel issue with the sort box
* More small fixes and updates
= 2.3.2 =
* possible hot-fix to header issues
* fix of Google docs issues
* privacy and protection updates
* still working on child categories
= 2.3.1 =
* htaccess update
* htaccess file editor in settings menu
* fixed a file not found error
= 2.3 =
* Batch file upload beta
* List of available short-codes
* Document page options added
** Default Content (Preview or Description)
** Show/Hide (Preview and Description)
= 2.2.2 =
* Minor bug fixes
* Small look and feel changes.
* Moved the language files into there own folder
= 2.2.1 =
* Changed the way preview works, added a preview button
* Added default sort options
= 2.2 =
* Added the ability to preview documents instead of a description.
* hot fix on the uninstall issue.  I hope this will solve the problem.
= 2.1.1 =
* fixed some header already sent messages.
= 2.1 =
* added a rating system
* code cleanup
* browser capability fixes
* updated the language file
= 2.0.2 =
* IE compatibility mode fix.
= 2.0.1 =
* Minor html fixes.  Thanks for the reports thibodeaux and ghalusa.
= 2.0 =
* Added a new or updated banner.
* Can now run a filesystem check to clean up and unwanted files or data.
* Can now sort files by any of the categories this sort option is saved for the session of the user.
* Restricted access to the file directory, now only Memphis Documents has access to the files.  Directory link to the files is denied.
* Added a setting menu with the following options
 * Change size of file list on both the site and dashboard
 * Hide our show certain fields of the file.
 * Hide/Show all files from everybody or just non-members
 * Hide/Show all post from everybody or just non-members
 * Hide/Show new and updated banner
 * Determine the length in days to display the new or update banner
* Updated the translation file.
= 1.4 =
* Changed the why sharing works.  Now you share the page that the file is on not the file itself.
* minor bug fixes.
= 1.3.2 =
* fixed permalink bug where the default setting would cause errors when trying to move from one category to another.
= 1.3.1 =
* small bug fixes
= 1.3 =
* Added the ability to disable social apps
* Added the ability to only allow members to download file
* Now have the ability to change the status of a file post
* Have the ability to hide/show your file.
* Changed add update dashboard control panel.
* Update po file.
= 1.2.8 =
*  Fixed broken category issue.
= 1.2.7 =
* fixed download error where the ability to download a file was broken.  This error occurring with the latest WordPress update 3.6.1. The fix was to include a WordPress file ' wp-includes/pluggable.php' that was removed from the WordPress master include list.
= 1.2.6 =
* Style sheet changes.
=1.2.5 =
* Fixed image links in description.
= 1.2.4 =
* Fixed a compatibility bug with Memphis Custom Log-in.
* Removed debugging text.
= 1.2.3 =
* Fixed a compatibility bug with Memphis Custom Log in.
= 1.2.2 
* Updated robots list.
= 1.2.1 =
* correct path to the mdocs-robots.txt file
= 1.2 =
* Google Plus message updated
* Twitter messages updated.
* Bot list updated
= 1.1 =
* Bots are not counted towards downloads.
* Changed style of dashboard menu.
* Minor bug fixes.
= 1.0.2 =
* Download button fix.
= 1.0.1 =
* Download button fix.
= 1.0 =
* Initial Release of Memphis Documents Library

== Upgrade Notice ==
= 1.0 =
* Initial Release of Memphis Documents Library