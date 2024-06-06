<title>ABOUT</title>

<x-layout> 
    <x-slot:heading>
        任务进度
    </x-slot:heading>


    <ul role="list" class="divide-y divide-gray-100">

        <x-about-list :finish='true' >记录包含标题和内容</x-about-list>
        <x-about-list :finish='true' >给单条记录添加 tag</x-about-list>
        <x-about-list :finish='true' >恢复被删除的记录</x-about-list>
        <x-about-list :finish='true' >登陆和注册</x-about-list>
        <x-about-list :finish='true' >文章在线增删查改</x-about-list>
        <x-about-list :finish='true' >权限认证</x-about-list>
        <x-about-list :finish='false' >支持复制单条记录</x-about-list>
        <x-about-list :finish='false' >测试&持续集成</x-about-list>

        
    </ul>
      


</x-layout>


