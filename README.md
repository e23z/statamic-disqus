statamic-disqus
===============

A Statamic add-on for Disqus which allows you to easily embed discussions into your pages by using `{{ disqus }}` tag in your templates and layouts. It also provides a method to count the total posts from any discussion, in case you want to show it in your blog layout.

## Installing
1. Copy the "_add-ons" folder contents to your statamic root directory;
2. Do the same to the files inside the "_config" directory;

  > Just be careful to respect the exact folder structure, okay?
3. Configure the "disqus.yaml" file with your custom values:
  * __disqus_forum__: the site you're moderating in Disqus for this project;
  * __disqus_key__: your Disqus app public key, for using the rest api;
  * __disqus_cache__: how long the cache will hold information for the count of the discussion posts on its memory. By the way, it's configured in _minutes_.
4. Enjoy! :)

## Usage
### Discussion embedding
To add Disqus comments to your layout, just use the `{{ disqus:comment }}` tag within your html template, just like this.

	{{ disqus:comments id="sample" title="Sample" }}

It requires two params:

* __id__: some identification which will be used to find this discussion later and count its total posts.
* __title__: the title for this page that appears when users look your site's discussions.

There's is also one optional parameter:
* __dev__: "true" or "false". Wheter you'd like or not to allow the Disqus forum to show up while you're under your development environment. I recommend using this with Statamic's environment configurations capabilities. So that you can hide Disqus on localhost and turn it on in production.

### Comments counting
Getting the total posts for any of your discussions is as simple as adding this to your page:

	{{ disqus:count id="sample" }}

__Id__ is the unique identification key you used to tag this discussion earlier, while using `{{ disqus:comment }}` or by embedding the Disqus manually.

> Note: if you didn't set any id to your discussion, I'm sorry, but you won't be able to get how many comments people have posted for your page/post.

## Notes
Disqus apps can be created [here in Disqus applications panel](https://disqus.com/api/applications/). After you submiting the form and registering your domains, you'll be able to enjoy their api resources and use the `{{ disqus:count }}` tag provided by this add-on.