const socialLinks = `
<ul class="bmn__social">
<li><a href="#">LinkedIn</a></li>
<li><a href="#">Twitter</a></li>
<li><a href="#">Github</a></li>
</ul>
`;

var bmn = new BMN();
bmn.init({
  dropdown: { icon: "chevron" },
  footer: {
    show: true,
    content: socialLinks
  }
});
