Description of Nightingale theme import into Moodle

# Nightingale Theme
Moodle based theme cloned from Boost but re-styled and templated completely using core Nightingale and Front-End framework designs from NHS Leadership Academy

## Installation instructions
This guide assumes you have a moodle install on your machine already.

- ```cd <path-to-your-moodle-root-directory>/theme/```

### Using Git
- If you want to get a copy of an existing theme repository (from [github.com](https://github.com)) – the command you need is `git clone`.
- ```git clone git@github.com:NHSLeadership/moodle-theme_nightingale.git```
- This would install the new theme directory inside your ```theme/``` folder

### Download Theme
- If not via ```git clone```, you can simply download the folder from [here](https://github.com:NHSLeadership/moodle-theme_nightingale.git)
- Place it in your ```theme/``` folder
- Login as site admin on your Moodle install
- Go to Site Administration > Notifications
- You should see the new Theme installation reflect there. Follow the instructions from Admin page to install the new theme.

## Node.js
### Check if you have Node.js

```node --version```

If the command says not found or doesn't return anything or says anything other
than 6.x.x LTS then you'll need to download the latest version.

## Install Node.js
Visit https://nodejs.org/en/ and download the LTS version. Run the installer
with the default options..

### Install the theme modules
The NHSLA Nightingale theme relies on a number of open source code 'modules' others have created on the web. These need to be added into the app before it can be used. Install the required modules by typing

```npm install```

You should be all installed and ready to go!

## Check it works

- Login as site admin on your Moodle install
- Go to Site Administration > Appearance > Theme > Theme Selector > Change Theme
- Select **Nightingale** from the list > Click on Use Theme
- Change settings if any for the new theme or leave them as is and click on Save Changes

That's it. The new theme should now reflect on your Moodle site!



---
