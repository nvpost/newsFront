
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

    <script scr="assets/materialize/materialize.js"></script>
    <link rel="assets/materialize/materialize.css"></link>

<!--    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>-->
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
                    Всего новостей: {{news.length}} из {{origin_news.length}}
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
                            :class="activeTags.indexOf(tag)!=-1?'active':false"
                            @click="addTag(tag)"
                    >{{tag}} {{counters[tag]}}
                    </div>
                </div>
                <div class="site_info" v-else>
                    Новости компании: <a :href="site.name" target="_blank">{{site.name}}</a>
                    <span class="close" @click="closeSite()"> X </span>
                </div>

                <div class="sites">
                    <select name="sites"
                            @change="setSite($event)"
                    >
                        <option>Сайт</option>
                        <option v-for="(s, index) in sites"
                                :value="s.name">{{s.name}} ({{s.category}} / {{s.lang}}) - {{siteNewsCounter[s.name]}}</option>
                    </select>
                </div>
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

