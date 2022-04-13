
<?php
require 'conf.php';
if(isset($_POST['own_log']) && log_func($_POST['own_log'])){



}else{
    echo "<link rel='stylesheet' href='login_css.css'>";
    echo "<form method='post' class='login'><input name='own_log' type='text'><input class='btn' type='submit' value='Войти'></form>";
    die();
}
?>


<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости</title>

<!--    <script src="assets/materialize/materialize.js"></script>-->
<!--    <link rel="stylesheet" href="assets/materialize/materialize.css"></link>-->

<!--    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="assets/libs/vue.js"></script>
    <link rel="stylesheet" href="css.css">

</head>
<body>
<div class="conatiner">
    <div id="app">
        <div class="pleloader_hover" v-if="preloader">
            <div class="preloader"></div>
        </div>



        <div class="info">
            <div class="header">
                <div class="news_counter">
                    Всего новостей: {{news.length}} из {{newsCount}}
                </div>

                <div class="select_lang">
                    <span v-for="(lang, index) in langs" @click="addLang(lang)"
                          :class="lang==activeLang?'active_text':''">{{lang}}</span>
                    <span class="close" v-if="activeLang" @click="addLang('off')">X</span>
                </div>
            </div>

            <div class="actions">
                <div class="tags" v-if="site.length==0">
                    <div
                            v-for="(tag, index) in tags"
                            class="tag"
                            :class="setTagClass(tag)"
                            @click="addTag(tag)"
                    >{{tag}} {{tagsCount[tag]}}

                    </div>
                </div>
                <div class="site_info" v-else>
                    Новости компании: <a :href="site.name" target="_blank">{{site.name}}</a>
                    <span class="close" @click="closeSite()"> X </span>
                </div>

                <div class="sites">
                    <select
                            name="sites"
                            @change="setSite($event)"
                    >
                        <option>Сайт</option>
                        <option v-for="(s, index) in sites"
                                :value="s.name">{{s.name}} ({{s.category}} / {{s.lang}}) - {{siteNewsCounter[s.name]}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="pagiantion_control">
            <div class="rows_lenght_field">
                <p>
                    Показывать по:
                <select name="rows_lenght" v-model="limit" @change="getNews(limit)">
                    <option value="100"">100</option>
                    <option value="200">200</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                    <option value="all">все</option>

                </select>
                </p>
            </div>
            <div class="pagination">
                <span class="page"
                      :class="key==activePage?'active':false"
                      @click="getNewPage(key)"
                      v-for="(p, key) in Math.ceil(newsCount/limit)">{{p}}</span>
            </div>
        </div>
        <table class="table">
            <tr>
                <th>Направление</th>


                <th>Язык</th>
                <th>Компания</th>
                <th>Дата</th>
                <th>Новость</th>
            </tr>
            <tr v-for = "(post, i) in news">
                <td>
                    <span
                            v-for="tag in post.group_id.split(',')"
                            class="table_tag"
                            @click = "addTag(tag, true)"
                    >
                       {{tag}}
                    </span>
                </td>


                <td><span @click="addLang(post.lang)"
                          class="table_lang"
                    >{{post.lang}}</span></td>
                <td>
                    <span
                            @click="setSite($event, post.site_id)"
                            class="table_tag">
                        {{post.site_id}}
                    </span>
                </td>
                <td class="date">{{date_tranform(post.news_date)}}</td>
                <td>
                    <a :href="post.link" target="_blank">
                        {{post.title}}
                    </a>
                </td>
            </tr>
        </table>

    </div>
</div>
</body>

<script src="js/js.js"></script>
