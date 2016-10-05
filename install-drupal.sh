#!/bin/sh

read -p "Please enter the machine name: " MACHINE_NAME

read -p "Please enter the site name: " SITE_NAME

PROFILE="standard"
PROJECTS="pathauto views ckeditor menu_attributes features imce jquery_update page_title imagemagick autoupload navbar"
ACCOUNT_PASS="admin"
ACCOUNT_MAIL="melliott@ccistudios.com"
ENABLE_MODULES="$PROJECTS views_ui update"
DISABLE_MODULES="overlay toolbar comment color dashboard dblog help search shortcut bartik seven"
SITE="drupal_temp"
DB_HOST="localhost"
DB_USER="root"
DB_PASS="root"
DB_NAME=$MACHINE_NAME
THEME_NAME=$MACHINE_NAME
DB_URL="mysql://$DB_USER:$DB_PASS@$DB_HOST/$DB_NAME"
HOME="/Users/melliott"
URL="$MACHINE_NAME.dev"
CWD=`pwd`

# create db, or drop tables
DB_EXISTS=`mysql -u $DB_USER -p$DB_PASS -e "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$MACHINE_NAME'"`
if [ $DB_EXISTS ]; then
	echo "DB $DRUPAL_DB_NAME exists, drop tables..."
	echo -n 'Are you sure, that you want to drop tables? (y/n) '
	read DO_DROP
	if [ $DO_DROP = y ]; then
		mysql -u $DB_USER -p$DB_PASS -e "DROP DATABASE $MACHINE_NAME; CREATE DATABASE $MACHINE_NAME;"
	else
		echo 'Exiting.'
		exit
	fi
else
	echo "Creating database $MACHINE_NAME..."
	mysqladmin -u $DB_USER -p$DB_PASS create $MACHINE_NAME
fi

drush qd --core=drupal-7.x --profile="$PROFILE" --account-pass="$ACCOUNT_PASS" --site-name="$SITE_NAME" --site-mail="$ACCOUNT_MAIL" --db-url="$DB_URL" -y "$SITE" $PROJECTS --no-server

shopt -s dotglob
mv "$SITE"/drupal-7.x/* ./
rm -rf "$SITE"

drush dl google_analytics adminimal_theme
drush en $ENABLE_MODULES googleanalytics adminimal -y
drush dis $DISABLE_MODULES -y

cp -R $HOME/libraries sites/all/libraries
cp -R $HOME/ckeditor/plugins/* sites/all/modules/ckeditor/plugins/

mkdir sites/all/drush
cp $HOME/aliases.drushrc.example.php sites/all/drush/aliases.drushrc.php

mkdir sites/all/themes/$THEME_NAME
cd sites/all/themes/$THEME_NAME/

echo "name = $SITE_NAME
description = $SITE_NAME Custom
core = 7.x

;scripts[] = js/filename.js

stylesheets[all][] = stylesheets/screen.css

regions[navigation] = Navigation
regions[header] = Header
regions[help] = Help
regions[content] = Content
regions[sidebar] = Sidebar
regions[widgets] = Widgets
regions[footer] = Footer
" > $THEME_NAME.info

mkdir js images sass

echo "@import \"reset\";
@import \"variables\";
@import \"typography\";
@import \"main\";
@import \"forms\";
@import \"front\";
@import \"responsive\";
" > sass/screen.scss

echo "*
{
	margin:0;
	padding:0;
}

a img
{
	border:0;
}

input, select, textarea, button
{
	font-family:inherit;
}
" > sass/_reset.scss

touch sass/_variables.scss sass/_typography.scss sass/_main.scss sass/_forms.scss sass/_front.scss sass/_responsive.scss

~/compass-add.sh

cp -R $HOME/starter-templates templates

drush en $THEME_NAME -y
drush vset theme_default $THEME_NAME
drush vset admin_theme adminimal
