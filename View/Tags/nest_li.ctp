<?php
echo $this->Html->script(array('jquery-sortable'));
?>
 <link href="http://johnny.github.io/jquery-sortable/css/vendor.css" rel="stylesheet">
  <link href="http://johnny.github.io/jquery-sortable/css/application.css" rel="stylesheet">
<ol class="default vertical">
              <li>
                Second
                <ol></ol>
              </li>
              <li>
                Third
                <ol>
                  <li class="">Second</li>
                  <li class="">
                First
                <ol></ol>
              </li>
              <li class="">Second</li>
              <li>First</li>
                  <li>
                    Third
                    <ol>
                      <li>First</li>

                    </ol>
                    <ol>
                      <li>First</li>
                      <li>Second</li>
                    </ol>
                  </li>
                </ol>
              </li>
              <li>Fourth</li>
              <li>Fifth</li>
              <li>Sixth</li>
            </ol>

            <!--
            between rows の 関係性を追加するUIを考える　d3d 導入は面倒だ。
            考えなければいけない範囲
            同一画面での並列関係の追加
            ベン図で表記不可能な　集合関係も描写するかを決定する。
            データ制御上の拡張の余地は残しておくべき　
            ネットワーク生成したデータ構造を　view の前段階でツリーに置き直して　ツリーとして表示するというのがいいのか？
            ネットワーク型だとsql そのまんまだからそんなこと考えなくていいのか？

            一番近い　tr 同士が　現在操作している行になるように自動で並び替える。
            関係先が何本かある状態でも、セットで選択できれば　ごちゃごちゃしないだろう。
            並列関係になっている記事同士飲みを抜粋して、アンラ化の方法で順番付けをする必要がある。
            順番付けの方法がたsearch のみでいいのかが問題。
             -->
            <script>
            function GETarray(obj){
            	console.log($('.default').sortable("serialize").get());
            }
            </script>
    <?php
echo $this->Html->script(array('application'));
echo $this->Form->input("Get_array",array("type" => "button" ,"onClick" => "GETarray(this)"));
?>