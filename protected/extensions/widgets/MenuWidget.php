<?php
class MenuWidget extends CWidget {
	public $items=array();
	public $test="";
	
	public function run() {
		$pos = 0;
		$handlers = '';
		foreach($this->items as $item) {
			$pos++;
			if (is_array($item['url'])){
				$link = $this->getController()->createUrl($item['url'][0],$item['url'][1]);
			} else {
				$link = $item['url'];
			}
			echo CHtml::openTag('a',array('href'=>$link, 'id'=>$item['link_id']))."\n";
				echo CHtml::openTag('div',array('id'=>'item_' . $pos, 'class'=>'index_button'))."\n";
					echo CHtml::openTag('span',array('id'=>'text_' . $pos))."\n";
						echo $item['label'];
					echo CHtml::closeTag('span');
				echo CHtml::closeTag('div');
			echo CHtml::closeTag('a');
			//$handlers .= "jQuery('body').undelegate('#" . $item['link_id'] . "','click').delegate('#" . $item['link_id'] . "','click',function(){\n" . CHtml::ajax(array('url' => $link, 'update' => '#changable_content')) . ";\n return false;\n});\n";
		}
		if ($handlers !== ''){
			?>
			<script type="text/javascript">
			/*<![CDATA[*/
			jQuery(function($) {
				<?php echo $handlers ?>
			});
			/*]]>*/
			</script>
			<?php
		}
	}
}