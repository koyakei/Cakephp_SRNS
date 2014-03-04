
			    <div class="control-group">
			        <?php echo $this->Form->label('keyword', 'キーワード', array('class' => 'control-label')); ?>
			        <div class="controls">
			        <?php echo $this->Form->text('keyword', array('class' => 'span12', 'placeholder' => 'タイトル、本文を対象に検索')); ?>
			        <?php
			            $options = array('and' => 'AND', 'or' => 'OR');
			            $attributes = array('default' => 'and', 'class' => 'radio inline');
			            echo $this->Form->radio('andor', $options, $attributes);
			            echo $this->Form->hidden('left',array('value' => true));
			        ?>
			        </div>
			    </div>
			