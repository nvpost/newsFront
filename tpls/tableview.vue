<template>
  <table class="table">
            <tr>
                <th>Направление</th>


                <th>Язык</th>
                <th>Компания</th>
                <th>Дата</th>
                <th>Дата парсинга</th>
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
                <td class="date">{{date_tranform(post.parse_date)}}</td>
                <td>
                    <a :href="post.link" target="_blank">
                        {{post.title}}
                    </a>
                </td>
            </tr>
        </table>
  </template>


<script>
module.exports = {
  data: function() {
    return {

    }
  },
  props: ['news'],
  methods:{
    date_tranform(date){
      d = new Date(date).toLocaleDateString()
      if (d=='Invalid Date'){
        d="Н/д"
      }
      return d
    },
  }
}
</script>