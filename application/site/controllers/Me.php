<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Me extends Common_Controller
{
    public $defaultLogo;
    public $defaultCover;

    public function __construct()
    {
        parent::__construct();
        $this->defaultLogo = static_file('img/me/logo.png');
        $this->defaultCover = static_file('img/me/ban.jpg');
    }

    public function index()
    {
        //首页封面和logo
        $index = $this->db->where('admin_id', 3)->select("id,logo,cover,tag,link")->get('index')->row_array();
        $index['logo'] = empty($index['logo']) ? $this->defaultLogo : upload_file(tag_photo($index['logo']));
        $index['cover'] = empty($index['cover']) ? $this->defaultCover : upload_file(tag_photo($index['cover']));
        $index['link'] = json_decode($index['link'], true);
        $data['index'] = $index;
        //文章列表
        $article = $this->db->where('admin_id', 3)->order_by('id', 'DESC')->select("id,title,tag,FROM_UNIXTIME(create_time,'%Y%m') months")->get('article')->limit(6)->result_array();
    
        $tag = array();
        $dateList = [];
        $tagName = [];
        foreach ($article as $val) {
            $month = date('Y年m月', strtotime($val['months'] . '01'));
            $dateList[$month][] = $val;
            $tag = array_unique(array_merge($tag, explode(',', $val['tag'])));
        }
        foreach ($tag as $val) {
            $tagName[] = $this->db->where(array('admin_id' => 3, 'id' => $val))->order_by('id', 'DESC')->select("id,title,remark")->get('tag')->row_array();
        }
        foreach ($article as &$value){
            $value['id'] = obj_hashids()->encode($value['id']);
        }
        $data['article'] = array_slice($article, 0, 5);
        $data['tagName'] = $tagName;
        $data['date'] = $dateList;
    
        


        $this->load->view('me', $data);
    }

    public function date($date = '')
    {
        empty($date) && $date = date('Ym');
        $article = $this->db->where('admin_id', 3)->order_by('id', 'DESC')->select("id,title,photo,text,tag,FROM_UNIXTIME(create_time,'%Y%m') months")->get('article')->result_array();
        foreach ($article as $key => $val) {
            $val['id'] = obj_hashids()->encode($val['id']);
            $val['pic'] = upload_file(tag_photo($val['photo']));
            $months = $val['months'];
            $dateList[$months][] = $val;
        }
        $data['nglist'] = isset($dateList[$date]) ? $dateList[$date] : [];
        $data['search'] = $date;
        if (empty($data['nglist'])){
            show_404();
        }
        $this->load->view('list', $data);
    }

    public function tag($tagName)
    {
        $tagName = urldecode($tagName);
        $tag = $this->db->where(array('admin_id' => 3, 'title' => $tagName))->select("id,title,remark")->get('tag')->row_array();
        $article = $this->db->where('admin_id', 3)->order_by('id', 'DESC')->select("id,title,photo,tag")->get('article')->result_array();
        if (!empty($article)) {
            foreach ($article as $val) {
                $val['id'] = obj_hashids()->encode($val['id']);
                $val['pic'] = upload_file(tag_photo($val['photo']));
                $tags = explode(',', $val['tag']);
                if (in_array($tag['id'], $tags)) {
                    $articleList[] = $val;
                }
            }
            if (!isset($articleList)){
                show_404();
            }
            $data['nglist'] = $articleList;
            $data['search'] = $tagName;
        
            $this->load->view('list', $data);
        }
    }

    public function aimer($id = 0)
    {
        $id = obj_hashids()->decode($id);
        if (empty($id)){
            redirect(site_url(''));
        }
        $article = $this->db->where('id', $id)->select('title,intro_left,intro_right,music,photo,image,tag,text,create_time,update_time')->get('article')->row_array();
        if (empty($article)) {
            redirect(site_url(''));
        }
        $imgList = explode(',', $article['image']);

        foreach ($imgList as $val) {
            $img[] = upload_file(tag_photo($val));
        }
        $article['img'] = $img;
        $nickname = $this->db->where('id', 3)->select('nickname')->get('manager')->row_array();
        $article['nickname'] = $nickname['nickname'];
        $page = array();
        $pageText = array();
        if (!empty($article['text'])) {
            $text = json_decode($article['text'], true);
            foreach ($text as $k => $v) {
                $p = $v['page'];
                if ($p < 2) //如果文本页等于1或小于1则不显示
                    continue;
                $page[] = $p;
                $pageText[$p] = $v['content'];
            }
        }
        $totalPage = ceil(count($img) / 2) + count($page) + 1;

        $newTextPage = array();
        $newPage = array();
        //过滤掉文本页超过总页数的
        foreach ($pageText as $key => $val)
        {
            if ($key>$totalPage){
                $totalPage = $totalPage - 1;
                continue;
            }
            $newPage[] = $key;
            $newTextPage["$key"] = $val;
        }
        $article['id'] = obj_hashids()->encode($id);
        $article['page'] = $newPage;
        $article['totalPage'] = $totalPage;
        $article['pageText'] = $newTextPage;
        $this->seoTitle = $article['title'] .' - ' .$this->seoTitle;
        $article['weibo_share'] = weibo_share(current_url(),$this->seoTitle,upload_file(tag_photo($article['photo'])));
        $article['qq_share'] = qq_share(current_url(),$this->seoTitle,upload_file(tag_photo($article['photo'])),strip_tags($article['intro_left']));
        $qr_code = qr_code(current_url());
        $article['wechat_share'] = $qr_code;
        $this->load->view('info', $article);
    }
}
