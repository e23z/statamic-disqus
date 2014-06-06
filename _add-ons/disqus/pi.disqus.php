<?php
class Plugin_disqus extends Plugin {

    var $meta = array(
        'name' => 'Disqus',
        'version' => '0.1',
        'author' => 'Edio Zalewski',
        'author_url' => 'htpp://firey.cc'
    );

    public function comments()
    {
        $forum = $this -> fetch('disqus_forum', null, null, false, false);
        $is_developer_mode = $this -> fetchParam('dev', false, false, true);
        $id = $this -> fetchParam('id', null);
        $title = $this->fetchParam('title', null, false, false, false);

        $is_developer_mode = $is_developer_mode ? '1' : '0';

        if ($forum)
        {
            $output = '
                        <div id="disqus_thread"></div>
                        <script type="text/javascript">
                            var disqus_shortname = "'.$forum.'"; // required: replace example with your forum shortname
                            var disqus_developer = '.$is_developer_mode.';
                            var disqus_identifier = "'.$id.'";
                            var disqus_title = "'.$title.'";
                            /* * * DON\'T EDIT BELOW THIS LINE * * */
                            (function() {
                                var dsq = document.createElement("script"); dsq.type = "text/javascript"; dsq.async = true;
                                dsq.src = "http://" + disqus_shortname + ".disqus.com/embed.js";
                                (document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
            ';
            return $output;
        }

        return '';
    }

    public function count()
    {
        $forum = $this -> fetch('disqus_forum', null, null, false, false);
        $key = $this -> fetch('disqus_key', null, null, false, false);
        $id = $this -> fetchParam('id', null);
        $cache_time = $this -> fetch('disqus_cache', 1) * 60;
        $url = "https://disqus.com/api/3.0/threads/details.json?api_key=".$key."&forum=".$forum."&thread:ident=".$id;

        $cached_result = $this -> cache -> getYAML($id);

        if ($cached_result)
        {
            if ($this -> cache -> getAge($id) > $cache_time)
            {
                $this -> cache -> delete($id);
                goto fetch;
            }
            else
            {
                $cached_result = $this -> cache -> get($id);
            }
        }
        else
        {
            fetch:
            {
                $session = curl_init($url);
                curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
                $data = curl_exec($session);
                curl_close($session);

                $json = json_decode($data);
                $cached_result = ($json -> code == 0) ? $json -> response -> posts : 0;

                $this -> cache -> put($id, $cached_result);
            }
        }

        return $cached_result;
    }

}
