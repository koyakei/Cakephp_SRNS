
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/0.10.0/angular-material.min.js"></script>

    <?php 	echo $this->Html->script(array('addArticle'));?>
  <article>
      <h2>Todo</h2>
    <div ng-app ng-controller="ArticleCtrl">
      <span>残り:{{remaining()}}/{{todos.length}}</span>
      <a href="" ng-click="archive()">完了</a>
<div>
               <?php
//                echo $this->Form->create("Article",array("ng-click"=>"addArticle(this);"));
		echo $this->Form->input('name',array("ng-model" => "name",
				"size"=>"30",
						"placeholder"=>"新しいArticleを追加"
		));
	?>
<?php echo $this->Form->input('user_id', array(
//
	    'type' => 'select',
	    'multiple'=> false,
	    'options' => $ulist,
	  'selected' => $currentUserID,
// 		"ng-model" => "user_id",
	));
echo $this->Form->input('auth',array(
		"ng-model" => "auth",
			'type' => 'select',
			'options' => array( 0 => 'public',1 => 'private'),
			'selected' => 0));
?>
               <div class="sorting_tags" style ="width: 200px; float:right;">
					<p>sorting tags</p>
					<ul>
					<li>
						<fieldset>
					        <?php
					echo $this->AutoCompleteNoHidden->input(
					    'sorting_tags.0',
					    array(
					        'autoCompletesUrl'=>$this->Html->url(
					            array(
					                'controller'=>'tagusers',
					                'action'=>'auto_complete',
					            )

					        ),
					    	'click_function' => 'all_reply_finder()',
					        'autoCompleteRequestItem'=>'autoCompleteText',
					    )
					);
					?>
<!-- 					<div class="search_tag_id"> -->
					<?php
					echo $this->Form->hidden('rtags',array('value' => '','class' => 'tag_id',
							 "ng-model"=>"rTagId","required" => false,"id" => "rTagId"));
					?>
<!-- 					</div> -->
					</fieldset></li>
			</ul>
	<?php
	echo $this->Form->button("Tag relation add",
      		array("ng-click" =>"addRTag(this)",
      		"class" => "btn-primary"));?>
	</div>
	<?php echo $this->Form->button("add",array("style" => "submit","ng-click"=>"addArticle(this)" ,"class" => "btn-primary"));?>

</div>
      <form ng-submit="separate()">
      <?php echo $this->Form->submit("separete",array("class" => "btn-primary"))?>

      </form>
      <table>
      	<tr  ng-repeat="(primeKey,prime) in primes">
      		<td class="done-{{prime.done}}">
      			<input type="checkbox" ng-model="prime.done">
      			{{prime.text}}
			</td>
<form ng-submit="rDel(this)">
				<td ng-repeat="(key,rTag) in prime.rTags">
      						<?php echo $this->Form->hidden("LinkID",
      						array("ng-model" =>"tagId","value" =>"{{rTag.Tag.ID}}"))?>
      						{{rTag.Tag.name}}<br>
      						{{rTag.O.username}}<br>
      						{{rTag.Link.ID}}



<?php
echo $this->Form->button("add",array("style" => "submit",
		"ng-click"=>"rDel(this)",
		"class" => "btn-primary"));?>

				</td>
				</form>
				</tr>

      </table>

      <div ng-repeat="separeted in separeteds">
      <br>
      <form ng-click="addRecStag()">
      <table ng-repeat="htmls in separeted">
      	<tr  ng-repeat="html in htmls">
      			<td>
      			{{html.text}}
      			<?php echo $this->Form->hidden("id",
      						array("ng-model" =>"id","value" =>"{{html.id}}")); ?>

				</td>
				<td ng-repeat="rTag in html.rTags">
				{{rTag.name}}
      				<?php echo $this->Form->hidden("id",
      						array("ng-model" =>"id","value" =>"{{rTag.id}}"))?>
				</td>
			</tr>
      </table>
      </form>
      </div>
      <!--
      <table ng-repeat="todo in todos" class="done-{{todo.done}}">
      <input type="checkbox" ng-model="todo.done">
      			{{todo.text}}
      </table> -->
      <div>

      </div>
    </div>
    </article>