# SnowTricks

The objective of this project is to create a collaborative snowboarding website to promote this sport to the general public and the learning of tricks.

To do this project I need to create the following pages:

   * the home page where the list of figures will appear;
   * the page for creating a new figure;
   * the edit page of a figure;
   * the presentation page of a figure (containing the common discussion space around a figure);
   * the page login; 
   * the page register;
   * the page forgetPassword;
   * the page new password; 

Before installing the project make sure you have PHP8 ^ and composer.

To install the project, open your terminal, copy the link and paste it in your development path or anywhere

      git clone https://github.com/weezycode/SnowTricks.git

After cloning the project, go to the folder

      cd SnowTricks

Now update the project

      composer install
      
After the update, launch the datasets

      symfony console d:f:l  
Or if you don't have the Symfony CLIENT    
   
      php bin/console doctrine:fixtures:load

Now launch a server 

      symfony serve       
Or

      php bin/console server:run
If you want to login use one of the credentials in UserFixtures.

<email>awa@free.fr<email>
   

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/9aa560c308764b34b5bcba84f86170d6)](https://www.codacy.com/gh/weezycode/SnowTricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=weezycode/SnowTricks&amp;utm_campaign=Badge_Grade)
