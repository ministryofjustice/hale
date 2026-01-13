/*
Restricts Embed Blocks

List of embed blocks
---

amazon-kindle
animoto
cloudup
collegehumor
crowdsignal
dailymotion
facebook
flickr
imgur
instagram
issuu
kickstarter
meetup-com
mixcloud
reddit
reverbnation
screencast
scribd
slideshare
smugmug
soundcloud
speaker-deck
spotify
ted
tiktok
tumblr
twitter
videopress
vimeo
wordpress
wordpress-tv
youtube
 */

wp.domReady(function () {
  const allowedEmbedBlocks = [
    'youtube',
    'vimeo',
    'twitter'
  ];
  wp.blocks.getBlockVariations('core/embed').forEach(function (blockVariation) {
    if (-1 === allowedEmbedBlocks.indexOf(blockVariation.name)) {
      wp.blocks.unregisterBlockVariation('core/embed', blockVariation.name);
    }
  });

  wp.blocks.getBlockVariations('core/heading').forEach(function (blockVariation) {
      wp.blocks.unregisterBlockVariation('core/heading', blockVariation.name);
  });

   wp.blocks.getBlockVariations('core/paragraph').forEach(function (blockVariation) {
      wp.blocks.unregisterBlockVariation('core/paragraph', blockVariation.name);
  });
    
});
