$(function() {
　$('.tab-item').click(function() {
　　var index = $('.tab-item').index(this);
　　$('.active').removeClass('active');
　　$(this).addClass('active');
　　$('.content-item').removeClass('show').eq(index).addClass('show');
　});

  $('#contents_btn').click(function() {
    var contents = $("#contents").get(0);
    contents.innerHTML = "【サービス概要】\n【3つのおすすめポイント】\n【こんな悩みを解決します】\n【サービス詳細】\n【実績】\n【料金形態】\n【対応可能なこと】\n【対応不可なこと】\n\nご質問がございましたら、気軽にリクエストしてください。\nお待ちしております。";
  })
});