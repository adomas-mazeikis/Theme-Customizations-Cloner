<?php
class Theme_Customizations_Cloner_Admin {

	var $export_page_id;
	var $options_group = 'theme-customizations-cloner';

	/**
	 * Constructor
	 */
	function Theme_Customizations_Cloner_Admin() {

		global $wp_version;

		add_action('plugins_loaded',array(__CLASS__,'plugins_loaded'));
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        }

	/**
	 * Admin Menu
	 */
	function admin_menu() {

		$this->settings_page_id = add_utility_page( 'Theme Customizations Cloner', 'Theme Customizations Cloner', 'manage_options', 'theme-cust-cloner', array( $this, 'utilities_page' ), '' );
                        
	}
	
	/*
	   Trigger download
	*/
   static function plugins_loaded() 
   {
      if(current_user_can( 'manage_options' ))
      {
         if(isset($_POST['export_theme']))
         {
            $mods=get_option('theme_mods_'.$_POST['export_theme']);
            header( 'Content-Description: File Transfer' );
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="'.$_POST['export_theme'].'"');
            header("Pragma: no-cache");
            header("Expires: 0");
            echo serialize( $mods);
            exit();
         }        
         
      }  
        
      
    }
	/**
	 * Utilities Page
	 */
	function utilities_page() {
         print_r($_FILES);
            $themes=wp_get_themes();
           
		?>

		<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div>
			<h2>Make Exporter for Theme Foundry</h2>
			<form action="" method="post" enctype="multipart/form-data">
				<?php
				if(current_user_can( 'manage_options' ))
            {
				   if(isset($_POST['import_theme']))
               {
                  
                  if(strlen($_FILES['themeMods']['tmp_name'])>0)
                  {
                     $mods=file_get_contents($_FILES['themeMods']['tmp_name']);
                     update_option('theme_mods_'.$_POST['import_theme'],sanitize_text_field($mods));
                  }
                  
               } 
				   echo "<p>Choose theme to export modifications:</p>";
				   echo "<p><select id='export_theme' name='export_theme'>";
				   foreach($themes as $theme_slug=>$theme)
               {
                  echo "<option value='".$theme_slug."'>".$theme->Name."</option>";
               }
               echo "</select></p>";
               echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Export modifications"></p>';
               echo '</form><form method="post" enctype="multipart/form-data">';
				   echo "<p>Warning! Importing theme modifications will overwrite current theme customizations. Please export if you want to save them.<br>Please select theme to import modifications:</p>";
				   echo "<p><select id='import_theme' name='import_theme'>";
				   foreach($themes as $theme_slug=>$theme)
               {
                  echo "<option value='".$theme_slug."'>".$theme->Name."</option>";
               }
               echo "</select></p>";
				   echo "<p>Choose modification file:</p>";
				   echo '<input type="file" name="themeMods">';
				   echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Import modifications"></p>';
				}
				else
				   echo "Not enough permissions. Please contact administrator to allow to manage options";
				?>
				
			</form>
		</div>

		<?php
	}

	

	

	
}

