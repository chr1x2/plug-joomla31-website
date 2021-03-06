<?php
/*------------------------------------------------------------------------
com_feedbackfactory - Feedback Factory 2.0.0
------------------------------------------------------------------------
author TheFactory
copyright Copyright (C) 2013 SKEPSIS Consult SRL. All Rights Reserved.
@license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
Websites: http://www.thefactory.ro
Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access'); ?>

<h1><?php echo JText::_('COM_FEEDBACKFACTORY_MOST_COMMENTED'); ?></h1>
<div class="faqsearch">
	<div class="faqsearchinputbox">
		<input name="query" type="text" id="faq_search_input" class="mostcommented" />
	</div>
</div> 
<br />
<div id="feedback-wrapper">  
   <fieldset>
  	<div id="searchresultdata" class="faq-articles">
  		<div class="update">
  		<?php echo $this->loadTemplate('list');  ?>
		</div> 
	</div>
  </fieldset>
</div>   
<br />
  
<script>
  var root = "<?php echo JUri::root(); ?>";
</script>
<script src="components/com_feedbackfactory/assets/js/main.js"></script>
