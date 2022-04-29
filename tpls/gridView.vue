<template>

    <div class="grid_field">

      <a
          v-for = "(post, i) in news"
          :href="post.link"
          target="_blank"
          class="news_item_link"
      >
        <div class="news_item"

             :style="{ backgroundImage: 'url('+post.image_url+')' }"
        >
          <div class="news_text">
            <div class="news_date">
              {{date_tranform(post.news_date)}} ({{date_tranform(post.parse_date)}})
            </div>
            <div class="news_header">
              <p>{{post.title}}</p>
            </div>
          </div>
        </div>

      </a>
    </div>

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


<style>
.grid_field{
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  color: #718096;
  text-decoration: none;
  font-size: 0.9em;
  margin-top: 20px;
}
.grid_field p{
  margin: 0px;
  padding: 0px;
}
.grid_field a {
  text-decoration: none;
  transition: 0.3s;
  cursor: pointer;
  color: #fff;
}

.news_item {

  height: 250px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  background-position: center;
  background-size: contain;
  background-repeat: no-repeat;
  transition: all 0.3s;
  cursor: pointer;
  border: 1px solid #ccc;

}
.news_item_link{
  width: 250px;
  margin-bottom: 20px;
}
.news_item:hover{
  transform: scale(1.1);
  box-shadow: 2px 2px 20px #6c6a6a;
}

.news_text{
  background-color: rgba(0, 0, 0, 0.75);
  color: #fff;
  padding: 10px;
}
.news_date {
  font-size: 0.8em;
}

/*news block image*/
.news_item_block .news_img,
.news_item_block .news_img img{
  width: 100%;
  height: auto;
  overflow: hidden;

}
</style>

