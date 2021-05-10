var input = document.querySelector('input[name="tags"]'),
    // init Tagify script on the above inputs
    tagify = new Tagify(input, {
      whitelist:
      ["急募","アフターフォロー","低価格","要相談","即日対応可","土日祝対応可","Zoom対応可","スタートアップ","ベンチャー","フリーランス","副業","独立","起業","在宅ワーク","未経験者OK","異業種交流会","セミナー","確定申告","税金","ノマド","働き方","ママさん応援","パパさん応援","ライフスタイル","育児","イベント"],
      maxTags: 5,
      dropdown: {
        maxItems: 50,           // <- mixumum allowed rendered suggestions
        classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
        enabled: 0,             // <- show suggestions on focus
        closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
      }
    });

// Chainable event listeners
tagify.on('add', onAddTag)
      .on('remove', onRemoveTag)
      .on('invalid', onInvalidTag);

// tag added callback
function onAddTag(e){
    console.log(e, e.detail);
    console.log( tagify.DOM.originalInput.value )
    tagify.off('add', onAddTag) // exmaple of removing a custom Tagify event
}

// tag remvoed callback
function onRemoveTag(e){
    console.log(e, e.detail);
}

// invalid tag added callback
function onInvalidTag(e){
    console.log(e, e.detail);
}

