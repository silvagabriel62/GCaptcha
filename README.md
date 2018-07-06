# GCaptcha
Open-source free PHP CAPTCHA script. Easy, lightweight and fully customizable.

### What is it?
**GCaptcha** is an open-source free PHP CAPTCHA script for generating challenge images and CAPTCHA codes to protect forms from spam and abuse. It can be easily added into existing forms on your website to provide protection from spam bots. 

We will keep working hardly in order to maintain this project updated.

### Why use it?
Most CAPTCHA scripts available are terribly annoying and too complicated to set up. They require lots of resources from your server and eventually use advertising, which may be something frustrating for your users. GCaptcha tries to bring an easier, simpler and highly customizable script, making the anti-spam process something enjoyable for both user and developer. 

**Features:**
- Show a challenge in a single line of code;
- Validate a submitted input in less than 5 lines of code;
- Customizable code length, character sets, parameters and others;
- Fully customizable appearance using pure CSS (basic and advanced);
- 3 ways to validate: using random codes, simple math problems or predefined words from a list;
- Lightweight audible challenges (beta);
- Several security features to prevent bots;
- Fast and efficient refreshable images;
- Case-sensitive option for security improvement;
- Fully developed in PHP, compatible with 99.9% servers;
- Works with most modern browsers and mobile devices;
- Open-source = free :)

### How does it work?
There are no mysteries on how our script works. When it's correctly set into a page, basically our script generates a validation code based on the settings you've chosen and stores it into an encrypted PHP session variable. Meanwhile, the image with the challenge is displayed inside a frame for the user, along with an input box where he needs to fill out with the response. When he submits the form, the form processor checks if the typed code (hashed) matches with the previously stored variable. If it's all OK, the application follows as programmed by it's developer. That's it!

### How to use it?
You don't actually need to configure GCaptcha after you download it. The only thing you need is show the image somewhere in your page and validate the code submitted from within your form processor. Here, we'll show you how to quick start using GCaptcha. 

First of all, you need to [download](https://github.com/silvagabriel62/GCaptcha/releases/download/0.1alpha/gcaptcha.0.1alpha.zip) the files and upload them to your server. We recommend you to upload these files into a designated folder into the root of your web directory (i.e. _http://www.yoursite.com/gcaptcha/_). All GCaptcha files must be together in the same folder!

**Reminder:** GCaptcha is a PHP script, what means your forms must be processed using PHP whenever you want to use it.

Next, we'll include a call to our stylesheet into the `<head>` section of the form display page:

```html
<link href="GCAPTCHA_PATH/style.css" rel="stylesheet">
```

**Be sure to replace each _GCAPTCHA_PATH_ with the full address of the folder you've put GCaptcha files in.**\
Now, at the point of the `<body>` section which you want to show the image, add the following code:

```html
<iframe id="captcha" src="GCAPTCHA_PATH/show.php"></iframe>
```

Into the `<form>`, add the following code to create a text input box:

```html
<input type="text" name="captcha_code">
<a href="javascript:void(0);" onclick="javascript:document.getElementById('captcha').contentWindow.reloadCaptcha();">[Generate another code]</a>
```

**Note:** The second line is optional. It gives the users the ability to refresh the image if they are having troubles reading it.

Now we'll work on the code that validates the CAPTCHA typed.\
Open the PHP file that processes the form data after submission. You can find this by looking at the `action` value inside your `<form>` tag.

On the first line of the file, add the following code:

```php
<?php include 'GCAPTCHA_PATH/gcaptcha.php'; ?>
```

**Warning:** The next few steps will vary depending on how form validation is handled in your code. If you have little or no PHP knowledge the next part can be difficult.

Next, to check if the CAPTCHA typed by the user is correct, use the following snippet:

```php
<?php
  if(isset($_POST['captcha_code']) && trim($_POST['captcha_code']) != ''){
    if(validateCaptcha($_POST['captcha_code'])){
      // The CAPTCHA code was validated and it's correct
      // After this, you can use the code you wish
    }else{
      // The CAPTCHA code wasn't validated and it's incorrect
      // After this, you can use the code you wish
    }
   }else{
     // The CAPTCHA code wasn't passed through the form
     // After this, you can use the code you wish
   }
 ?>
```

Into the indicated spots, you can use your own code to process post-validation actions or anything else.\
Be sure to let the user know when something wrong happens, showing an error message when the typed CAPTCHA is incorrect and giving the user the ability to try that again. 

If you had troubles understanding the process above, you can download an explained example file [here](https://github.com/silvagabriel62/GCaptcha/releases/download/0.1alpha/example.zip).

Please do not forget that this was just a guide for beginners on GCaptcha. If you are an advanced user and understood properly how our script works, you are totally free to explore it, customize it and modify it to match your application style and functionality.

### How to customize it?
You can change the script settings (code generation method, code length, case-sensitive, etc.) by modifying the _gcaptcha.php_ file.
Also, you can customize the image appearance (container/font size, distortion, color, background, etc.) by modifying the _style.css_ file.

Both files are self-explained, but you need minimum CSS knowledge in order to customize the appearance settings.

### Where can I download it?
You can grab GCaptcha binaries here:

[gcaptcha.0.1alpha.zip](https://github.com/silvagabriel62/GCaptcha/releases/download/0.1alpha/gcaptcha.0.1alpha.zip) (Last updated on 04/13/2018)

GCaptcha includes 3rd party scripts from Niklas von Hertzen ([html2canvas](https://html2canvas.hertzen.com/)).\
GCaptcha is licensed as a free open-source software.

### Beta feature: audible challenges
If you wish, you can also allow the user to listen to the CAPTCHA challenge!\
To do that, you will use the same implementation method as shown above, with a few changes:

To load our audio-capable interface, you must change the following line:

```html
<iframe id="captcha" src="GCAPTCHA_PATH/show.php"></iframe>
```

When showing the image at the page to:

```html
<iframe id="captcha" src="GCAPTCHA_PATH/show_audio.php"></iframe>
```

And to create a button which will allow the user to start/stop listening the challenge, use the following snippet:

```html
<a href="javascript:void(0);" onclick="javascript:document.getElementById('captcha').contentWindow.playCaptcha();">[Listen/Stop code]</a>
```

If you had troubles understanding the process above, you can download an explained example file [here](https://github.com/silvagabriel62/GCaptcha/releases/download/0.1alpha/example.zip).

**Warning:** audible challenges are an experimental feature, what means they may not work properly in all browsers and devices. We are working hard to make this function stable and efficient, please stay tuned in new updates.

### Tips & Troubleshooting

**Script requirements**\
This script will only work if the browser has cookies enabled. It cannot run on servers which PHP session feature is not available somehow. Stable PHP 5.5 or newer is highly recommended. To use audio features, the browser must support HTML5 audio tags and Web Speech API interface. 

**Using predefined words from a list**\
If you want the user to be prompted with a range of predefined words instead of a random code, you can use our word list functionality. To do this, simply change the code generation method (in the _gcaptcha.php_ file) to option 2. The word list is read from the file _words.txt_, which consists of a simple database with one word per line, without trailing spaces. Modify this file to change the word list. You can also try using phrases or multiple words at once, just by setting each challenge in one line of this file. Just be careful when using very large word lists: they demand memory from your server and may decrease your page's loading performance. 

**Multiple instances**\
For now, you cannot use more than one CAPTCHA on the same page. This will lead to a code conflict and make all instances unusable. 

**Call stack error (session_start problem)**\
If you are experiencing this issue, be sure to include the GCaptcha loader (_gcaptcha.php_) in the very FIRST line of the form processor file (as explained above). The script itself starts the PHP session, so there can't be no other `session_start()` command in the same file. 

**The code isn't being passed through the form**\
You have to make sure that you're using the same processing method when submitting the form (`method` value into `<form>` tag) and in the validation code (`$_GET` or `$_POST` according to the method you chose previously). We always recommend you to use the `$_POST` method in order to prevent security breaks.
