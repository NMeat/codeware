# -*- coding: utf-8 -*-
import scrapy


class QuotesSpider(scrapy.Spider):
    name = 'quotes'
    allowed_domains = ['quotes.toscarpe.com']
    start_urls = ['http://quotes.toscrape.com/']

    def parse(self, response):
        pass
