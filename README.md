# Shortener

Project implements task:
https://docs.google.com/document/d/1iqu82SKCKdkdxyTTQN8v6Y7Myb7oJTemeNXE7ZgPU9A/edit#

## Requirements

- PHP 7.4 or higher
- MariaDB 10.1 or higher/MySQL 8.0 or higher
- Linux Debian 9 or higher/Ubuntu 20 or higher
- The PHP command must be accessible from the console (it used for async on specification)
- Globally installed **Composer** (command **composer** in console for install script)

## Install

### First

Clone repo: `composer create-project --prefer-dist aleks-chigintsev/ptt-shortener ptt_shortener`

### Second

In **/console/bash**, run **init.sh with the -h parameter**
for more details

After that, configure your web server for the file 
**index.php** in the **backend/web** folder

# Configure

After init project config file