<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
include(dirname(dirname(__FILE__)) . DS .  'common_params.php');
$plugin = (!empty($this->templateVars['plugin']))? "'plugin' => '".strtolower($this->templateVars['plugin'])."', " : null;
?>
<div class="<?php echo $pluralVar;?> index">
	<h2><?php echo "<?php echo __('{$pluralHumanName}');?>";?></h2>

<?php echo "<?php\n";?>
	echo $this->Form->create('<?php echo $modelClass;?>', array(
		'url' => array_merge(array(<?php echo $plugin ?>'action' => 'index'), $this->params['pass'])
		));
	//echo $this->Form->input('title', array('div' => false));
	echo $this->Form->submit(__('Search', true), array('div' => false));
	echo $this->Form->end();
<?php echo '?>';?>

	<table cellpadding="0" cellspacing="0">
	<tr>
	<?php  foreach ($fields as $field):
		if(count($this->templateVars['schema'][$field]) > 1){
				//add subDocData methds here
		}else{?>
			<th><?php echo "<?php echo \$this->Paginator->sort('{$field}', null, array('url'=>array({$plugin})));?>";?></th>
	<?php 
		}
	endforeach;?>
		<th class="actions"><?php echo "<?php echo __('Actions');?>";?></th>
	</tr>
	<?php 
	echo "<?php
	\$i = 0;
	foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t<tr>\n";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				if(count($this->templateVars['schema'][$field]) > 1){
				//add subDocData methds here
				}else{
					if($this->templateVars['schema'][$field]['type'] == 'datetime'){
						echo "\t\t<td><?php echo h(\$this->MongoHtml->mongodate(\${$singularVar}['{$modelClass}']['{$field}'])); ?>&nbsp;</td>\n";
					}else{
						echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
					}
				}
			}
		}
		
		$idKeyPK = $idKey = "\${$singularVar}['{$modelClass}']['{$primaryKey}']";
		if ($slugged) {
			$idKey = "\${$singularVar}['{$modelClass}']['slug']";
		}


		echo "\t\t<td class=\"actions\">\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('View'), array({$plugin} 'action' => 'view', {$idKey})); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Html->link(__('Edit'), array({$plugin} 'action' => 'edit', {$idKeyPK})); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Form->postLink(__('Delete'), array({$plugin}'action' => 'delete', {$idKeyPK}), null, __('Are you sure you want to delete %s?', {$idKeyPK})); ?>\n";
		echo "\t\t</td>\n";
	echo "\t</tr>\n";

	echo "<?php endforeach; ?>\n";
	?>
	</table>
	<p>
	<?php echo "<?php
	echo \$this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>";?>
	</p>

	<div class="paging">
	<?php
		echo "<?php\n";
		echo "\t\techo \$this->Paginator->prev('< ' . __('previous'), array('url' => array({$plugin})), null, array({$plugin}'class' => 'prev disabled'));\n";
		echo "\t\techo \$this->Paginator->numbers(array('separator' => ''));\n";
		echo "\t\techo \$this->Paginator->next(__('next') . ' >', array({$plugin}), null, array({$plugin}'class' => 'next disabled'));\n";
		echo "\t?>\n";
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo "<?php echo __('Actions'); ?>"; ?></h3>
	<ul>
		<li><?php echo "<?php echo \$this->Html->link(__('New " . $singularHumanName . "'), array({$plugin}'action' => 'add')); ?>";?></li>
<?php
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t\t<li><?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')); ?> </li>\n";
				echo "\t\t<li><?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')); ?> </li>\n";
				$done[] = $details['controller'];
			}
		}
	}
?>
	</ul>
</div>
