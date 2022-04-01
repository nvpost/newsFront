
let app = new Vue({
    'el': '#app',
    data() {
        return {
            'tags': [],
            'news': []
        }
    },
    beforeCreate(){
        console.log('hi')

            fetch('server/getData.php')
            .then(res=>res.json())
            .then((data) => {
                this.news = data.data
                this.tags = data.tags
            })
    },

    methods:{
        d(date){
            return new Date(date)
        }
    }
})