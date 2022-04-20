
let app = new Vue({
    'el': '#app',
    data() {
        return {
            'tags': [],
            'tagsCount':[],
            'origin_news': [],
            'news': [],
            'origin_sites':[],
            // 'siteNewsCounter':[],
            'sites': [],
            'site': {
                name:false,
                data:false
            },
            'activeTags': [],
            'counters': [],
            'langs':[],
            'activeLang':"",
            'preloader': true,
            'limit': 200,
            'newsCount':0,
            'activePage':0,
            'news_date_selector':true,
            ru: vdp_translation_ru.js,
            'newsDate':{
                start: null,
                stop: new Date()
            },
            'parseDate':{
                start: null,
                stop: null
            },
            'date_field': 'news_date',
            // originDates:
            'originDates':{
                'newsDate':{
                    start: null,
                    stop: new Date()
                },
                'parseDate':{
                    start: null,
                    stop: null
                },
            }


        }
    },
    components: {
        vuejsDatepicker
    },

    //Переписать теги на key=>value (название => число), взять из server/getNewsCount.php
    created(){
        fetch('server/getNewsCount.php')
            .then(res=>res.json())
            .then(data=>{
                // this.newsCount = data.count
                this.tags = data.tagCount
                this.sites = data.siteAndCountArray

                this.parseDate.start = data.parse_min_max.min
                this.parseDate.stop = data.parse_min_max.max

                this.originDates.parseDate.start = data.parse_min_max.min
                this.originDates.parseDate.stop = data.parse_min_max.max

                console.log(data)

                this.getNews(this.limit)
            })

    },

    methods:{

        getNews(l=this.limit, offset=0){
            // let l = this.limit ? this.limit : 100;
            activeTagsForSQL = this.activeTags.map(i=>{return "'%"+i+"%'"})
            dates = {
                field: this.date_field,
                news_dates: this.newsDate,
                parse_dates: this.parseDate
            }
            fetch('server/getData.php',{
                method: 'POST',
                body:JSON.stringify({
                    limit: l,
                    offset: offset,
                    tags:activeTagsForSQL,
                    site: this.site.name,
                    dates: dates
                })
            })
                .then(res=>res.json())
                .then((data) => {
                    this.news = data.data

                    this.preloader=false
                    this.newsCount = data.newsInSet
                    if(this.site.name){
                        this.site.data = data.site[0]
                    }
                    console.log(data)

                })
        },
        setDates(){
            this.getNews()

        },
        getNewPage(key){
            let offset = key*this.limit
            this.getNews(this.limit, offset)
            this.activePage = key;
        },
        date_tranform(date){
            d = new Date(date)
            return d.toLocaleDateString()
        },

        addTag(t, remove=true){
            if(this.activeTags.indexOf(t)!=-1){
                if(remove){
                    this.activeTags.splice(this.activeTags.indexOf(t),1)
                }
            }else{
                this.activeTags.push(t)
            }
            this.getNews(this.limit, 0)
            // this.newSet()
        },

        addLang(l){
            if(this.activeLang == l || l=='off'){
                this.activeLang = ""
                app.news = app.origin_news
            }else{
                this.activeLang=l
                this.newSetLang()
            }


        },
        setSite(e, val=false){
            this.activeTags = []
            this.site.name = e.target.value
            this.getNews(this.limit, 0)
        },


        newSetLang(){
            this.news = this.origin_news
            ns = this.news.filter(i=>{
                return i.lang == this.activeLang
            })
            this.news = ns
        },
        closeSite(){
            this.site = [];
            this.news = this.origin_news
        },
        setTagClass(tag){
            cl = this.activeTags.indexOf(tag)!=-1?'active':false
            return cl
        },
        newsDateSelector(e){
            v = e.target.value
            document.querySelectorAll('.datepickers').forEach((i)=>{
                i.style.display = 'none'
            })
            document.querySelector('#'+v).style.display = 'flex';
            this.date_field = v

            this.newsDate = this.originDates.newsDate
            this.parseDate = this.originDates.parseDate

        }

    }
})



