<?xml version="1.0" encoding="UTF-8"?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
       http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"> {zzz:navlist type=all num=1000}
  {zzz:navlist1 sid=[navlist:sid] num=1000}
  <url>
    <loc>{zzz:siteurl}[navlist1:link]</loc>
    <priority>1.0</priority>
    <lastmod>[navlist1:time]</lastmod>
    <changefreq>always</changefreq>
  </url>{/zzz:navlist1}{zzz:content sid=[navlist:sid] order=order num=1000}
  <url>
    <loc>{zzz:siteurl}[content:link]</loc>
    <priority>1.0</priority>
    <lastmod>[content:time]</lastmod>
    <changefreq>always</changefreq>
  </url>{/zzz:content}{/zzz:navlist}
</urlset>
