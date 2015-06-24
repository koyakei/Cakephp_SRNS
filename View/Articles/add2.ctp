
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/0.10.0/angular-material.min.js"></script>

    <?php 	echo $this->Html->script(array('addArticle'));?>
    <script>

    </script>
  <article>
      <h2>Todo</h2>
    <div ng-app ng-controller="ArticleCtrl">
      <span>残り:{{remaining()}}/{{todos.length}}</span>
      <a href="" ng-click="archive()">完了</a>

      <form ng-submit="addArticle()">
        <input type="text" ng-model="articleText"  size="30"
               placeholder="新しいArticleを追加">
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
					<div class="search_tag_id">
					<?php
					echo $this->Form->hidden('sorting_tags..',array('value' => '','class' => 'tag_id',
							"ng-model"=>"tagId"));
					?>
					</div>
					</fieldset></li>
			</ul>
	</div>
        <?php

        echo $this->Form->submit("add",array("class" => "btn-primary"))?>
      </form>
      <form ng-submit="separate()">
      <?php echo $this->Form->submit("separete",array("class" => "btn-primary"))?>
      <table>
      	<tr  ng-repeat="todo in todos">
      		<td class="done-{{todo.done}}">
      			<input type="checkbox" ng-model="todo.done">
      			{{todo.text}}
			</td>
      </table>
      </form>
      <div ng-repeat="separeted in separeteds">
      {{separeted}}
      <table ng-repeat="htmls in separeted">
      	<tr  ng-repeat="html in htmls">
      			<td>
      			{{html.text}}
			</td>
			</tr>
      </table>
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