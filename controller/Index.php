<?php
namespace app\index\controller;

use app\index\model\Note;
use think\Controller;
use think\Log;

class Index extends Controller
{
    public function add()
    {
        //返回添加视图
        return view('note/add');
    }
    /**
     * 添加
     */
    function adddo()
    {
        //接收数据
        $data = input();
        //验证数据
        $validate = $this->validate($data,[
            'title|标题' => "require",
            'content|内容' => "require",
        ]);
        if (true !== $validate) {
            return json(["code"=>100,"msg"=>$validate,"data"=>[]]);
        }
        //添加入库
        $data = Note::create($data,true);
        Log::write('写入日志');
        return json(["code"=>200,"msg"=>"success","data"=>$data]);
    }
    function list(){
        //查询数据
        $data = model('Note')->paginate(5);
        return view('note/list',['data'=>$data]);
    }
    function del(){
        //接收参数
        $id = input('id');
        //查询数据
        $info = Note::get($id)->toArray();
        if (!$info['isfa']) {
            Note::destroy($id);
//            $this->redirect('index/Index/list');

        }else{
            $this->error('正在上架不得删除');
        }
    }

}
