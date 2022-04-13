
let app = new Vue({
    'el': '#app',
    data() {
        return {
            'tags': [],
            'tagsCount':[],
            'origin_news': [],
            'news': [],
            'origin_sites':[],
            'siteNewsCounter':[],
            'sites': [],
            'site':[],
            'activeTags': [],
            'excludeTags': [],
            'counters': [],
            'langs':[],
            'activeLang':"",
            'preloader': true,
            'limit': 200,
            'newsCount':0,
            'activePage':0

        }
    },
    created(){
        this.getNews(this.limit)
    },

    methods:{
        getNews(l, offset=0){
            // let l = this.limit ? this.limit : 100;
            fetch('server/getNewsCount.php')
                .then(res=>res.json())
                .then(data=>{
                    this.newsCount = data.count;
                    this.tagsCount = data.tagCount
                    console.log(data)
                })
            fetch('server/getData.php',{
                method: 'POST',
                body:JSON.stringify({limit: l, offset: offset})
            })
                .then(res=>res.json())
                .then((data) => {
                    this.news = data.data
                    this.tags = data.tags
                    this.sites = data.sites

                    this.origin_news = this.news
                    this.origin_sites = this.sites

                    // this.setCouters()
                    this.siteCounter()
                    this.langs = [...new Set(this.sites.map(i=>{return i.lang}))]

                    this.preloader=false
                    console.log(data)

                })
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
        // setCouters(){
        //     this.news.forEach(i=>{
        //         app.tags.forEach(j=>{
        //             if(i.group_id.indexOf(j)!=-1){
        //                 if(!app.counters[j]){
        //                     app.counters[j]=1
        //                 }else{
        //                     app.counters[j]++
        //                 }
        //             }
        //         })
        //     })
        // },
        siteCounter(site){
            this.news.forEach(i=>{
                this.sites.forEach(j=>{
                    n = j.name
                    if(i.site_id==n) {
                        if (!app.siteNewsCounter[n]) {
                            app.siteNewsCounter[n] = 1
                        } else {
                            app.siteNewsCounter[n]++
                        }
                    }
                })

            })
            // console.log(app.siteNewsCounter)
        },
        addTag(t, remove=true){
            if(this.activeTags.indexOf(t)!=-1){
                if(remove){
                    this.activeTags.splice(this.activeTags.indexOf(t),1)
                }
            }else{
                this.activeTags.push(t)
            }
            this.newSet()
        },
        excludeTag(e, t, remove=true){
            event.stopPropagation();
            if(this.excludeTags.indexOf(t)!=-1){
                if(remove){
                    this.excludeTags.splice(this.excludeTags.indexOf(t),1)
                }
            }else{
                this.excludeTags.push(t)
            }
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
            this.news = this.origin_news
            if(!val){
                val = e.target.value
            }
            ns = this.news.filter(i=>{
                return i.site_id == val
            })
            this.news = ns

            this.sites = this.origin_sites
             s = this.sites.filter(i=>{
                return i.name == val
            })
            this.site = s[0]
        },

        checkTagClass(t){
            return this.activeTags.indexOf(t)!=-1
        },
        newSet(){
            this.news = this.origin_news
            ns = this.news.filter(i=>{
               returnFlag = false;
               app.activeTags.forEach(j=>{
                   // Если хоть один элемент из массива активных датчиков совпадает
                   if(i.group_id.indexOf(j)!=-1){
                       returnFlag=true
                   }
               })
                if(app.activeTags.length==0){
                    returnFlag = true;
                }
                return returnFlag
            })
            this.news = ns
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
            let cl=""
            cl = this.activeTags.indexOf(tag)!=-1 ? 'active':false
            cl = this.excludeTags.indexOf(tag)!=-1?'disabled':false

            return cl
        }


    }
})

//timeout для materialize
// setTimeout('M.AutoInit()', 750)


