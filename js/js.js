
let app = new Vue({
    'el': '#app',
    data() {
        return {
            'tags': [],
            'origin_news': [],
            'news': [],
            'sites': [],
            'activeTags': [],
            'counters': []
        }
    },
    beforeCreate(){
        console.log('hi')

            fetch('server/getData.php')
            .then(res=>res.json())
            .then((data) => {
                this.news = data.data
                this.tags = data.tags
                this.sites = data.sites

                this.origin_news = this.news

                this.setCouters()

            })
    },

    methods:{
        d(date){
            return new Date(date)
        },
        setCouters(){
            this.news.forEach(i=>{
                app.tags.forEach(j=>{
                    if(i.group_id.indexOf(j)!=-1){
                        if(!app.counters[j]){
                            app.counters[j]=1
                        }else{
                            app.counters[j]++
                        }

                    }

                })
            })
        },
        addTag(t){
            if(this.activeTags.indexOf(t)!=-1){
                console.log(this.activeTags.indexOf(t))
                this.activeTags.splice(this.activeTags.indexOf(t),1)
            }else{
                this.activeTags.push(t)
                console.log('Добавлен ', t)
            }
            this.newSet()
        },
        checkTagClass(t){
            return this.activeTags.indexOf(t)!=-1
        },
        newSet(){
            this.news = this.origin_news
           ns = this.news.filter(i=>{
               returnFlag = true;
               app.activeTags.forEach(j=>{
                   returnFlag = i.group_id.indexOf(j)!=-1
               })
               return returnFlag
           })
            this.news = ns
        },


    }
})


