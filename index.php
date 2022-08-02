
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


    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="assets/libs/vue.js"></script>

    <script src="assets/libs/http-vue-loader.js"></script>
    <script src="assets/libs/datapicker/datepicker.js"></script>
    <script src="assets/libs/datapicker/ru.js"></script>

    <link rel="stylesheet" href="css.css">

</head>
<body>
<div class="conatiner">
    <div id="app">
        <div class="pleloader_hover" v-if="preloader">
            <div class="preloader"></div>
        </div>

        <div class="mobile_hamburger_field">
            <div class="hamburger" onclick="openMobileMenu(this)">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="top_actions">
            <div class="info">
                <div class="header">
                    <div class="news_counter">
                        Всего новостей: <span class="news_counter_field">{{news.length}} из {{newsCount}}</span>
                    </div>
                    <div class="select_view">Вид:
                        <span class="view_mode__field">
                            <span :class="viewMode=='table'?'active_view':''" @click="viewMode='table'">таблица</span>
                            /
                            <span :class="viewMode=='grid'?'active_view':''" @click="viewMode='grid'">плитка с картинками</span>
                        </span>
                    </div>

                </div>

                <div class="actions">
                    <div class="tags" v-if="!site.name">
                        <div
                                v-for="(count, key) in tags"
                                class="tag"
                                :class="setTagClass(key)"
                                @click="addTag(key)"
                        >{{key}} {{count}}

                        </div>
                    </div>
                    <div class="site_info" v-else>
                        Новости компании: <a :href="site.data.link" target="_blank">{{site.name}}</a>,
                        группа: {{site.data.category}},
                        язык: {{site.data.lang}}
                        <span class="close" @click="closeSite()"> X </span>
                    </div>

                    <div class="sites">
                        <select
                                name="sites"
                                @change="setSite($event)"
                        >
                            <option>Сайт</option>
                            <option v-for="(count, key) in sites"
                                    :value="key">{{key}} ({{count.lang}} / {{count.tags}}) - {{count.count}}</option>
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
                        <option value="300">300</option>
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                        <option value="all">все</option>

                    </select>
                    </p>
                </div>
                <div class="date_select_wrapper">
                    <div class="date_selector">
                        <select name="date_type" id="date_type" @change="newsDateSelector($event)">
                            <option value="news_date">Дата новости</option>
                            <option value="parse_date">Дата парсинга</option>
                        </select>
                    </div>
                        <div class="datepickers" id="news_date">
                            <vuejs-datepicker :language="ru"
                                              v-model="newsDate.start"
                                              :clear-button="true"
                                              placeholder="Старт"
                                              calendar-class="calendar_class"
                                              @input="setDates()"
                            ></vuejs-datepicker>
                            <vuejs-datepicker :language="ru"
                                              v-model="newsDate.stop"
                                              :clear-button="true"
                                              placeholder="Стоп"
                                              @input="setDates()"
                            ></vuejs-datepicker>
                        </div>


                        <div class="datepickers" id="parse_date" style="display:none">
                            <vuejs-datepicker :language="ru"
                                              v-model="parseDate.start"
                                              :clear-button="true"
                                              placeholder="Старт"
                                              calendar-class="calendar_class"
                                              @input="setDates()"

                            ></vuejs-datepicker>
                            <vuejs-datepicker :language="ru"
                                              v-model="parseDate.stop"
                                              :clear-button="true"
                                              placeholder="Стоп"
                                              @input="setDates()"
                            ></vuejs-datepicker>
                        </div>


                </div>
                <div class="pagination">
                    <span class="page"
                          :class="key==activePage?'active':false"
                          @click="getNewPage(key)"
                          v-for="(p, key) in Math.ceil(newsCount/limit)">{{p}}</span>
                </div>
            </div>
        </div>
        <gridview :news="news" v-if="viewMode=='grid'"></gridview>
        <tableview :news="news" v-if="viewMode=='table'"></tableview>

        <div class="pagination">
                <span class="page"
                      :class="key==activePage?'active':false"
                      @click="getNewPage(key)"
                      v-for="(p, key) in Math.ceil(newsCount/limit)">{{p}}</span>
        </div>

    </div>
</div>
</body>

<script src="js/js.js?3"></script>

<script>
    function openMobileMenu(e){
        console.log(e)
        if (e.classList.contains('open')){
            e.classList.remove('open')
        }else{
            e.classList.add('open')
        }
    }
</script>




