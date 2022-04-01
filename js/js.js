
let app = new Vue({
    'el': '#app',
    data() {
        return {
            'tags': [],
            'origin_news':[],
            'news': [],
            'activeTags':[],
        }
    },
    beforeCreate(){
        console.log('hi')

            fetch('server/getData.php')
            .then(res=>res.json())
            .then((data) => {
                this.news = data.data
                this.tags = data.tags

                this.origin_news = this.news
            })
    },

    methods:{
        d(date){
            return new Date(date)
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
        }

    }
})