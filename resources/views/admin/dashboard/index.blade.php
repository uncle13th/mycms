@extends('admin.layouts.app')

@section('title', '仪表板')

@section('breadcrumb')
<span>仪表板</span>
<i class="fas fa-chevron-right"></i>
<span>概览</span>
@endsection

@section('content')
<!-- 统计卡片 -->
<div class="stats-container">
    <div class="stat-card">
        <h3>总用户数</h3>
        <div class="stat-value">1,234</div>
        <div class="stat-trend">
            <i class="fas fa-arrow-up"></i> 12% 较上周
        </div>
    </div>
    <div class="stat-card">
        <h3>今日访问量</h3>
        <div class="stat-value">423</div>
        <div class="stat-trend">
            <i class="fas fa-arrow-up"></i> 5% 较昨日
        </div>
    </div>
    <div class="stat-card">
        <h3>内容数量</h3>
        <div class="stat-value">89</div>
        <div class="stat-trend">
            <i class="fas fa-arrow-up"></i> 8% 较上月
        </div>
    </div>
    <div class="stat-card">
        <h3>系统消息</h3>
        <div class="stat-value">12</div>
        <div class="stat-trend down">
            <i class="fas fa-arrow-down"></i> 2% 较昨日
        </div>
    </div>
</div>

<!-- 图表区域 -->
<div class="charts-container">
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">访问趋势</h3>
            <div class="chart-actions">
                <span class="chart-action">今日</span>
                <span class="chart-action">本周</span>
                <span class="chart-action">本月</span>
            </div>
        </div>
        <div id="visits-chart" style="height: 300px;">
            <!-- 这里可以集成 ECharts 等图表库 -->
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">用户分布</h3>
            <div class="chart-actions">
                <span class="chart-action">详情</span>
            </div>
        </div>
        <div id="users-chart" style="height: 300px;">
            <!-- 这里可以集成 ECharts 等图表库 -->
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* 统计卡片样式 */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
    }

    .stat-card {
        background: #fff;
        padding: 24px;
        border-radius: 4px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    }

    .stat-card h3 {
        color: #666;
        font-size: 14px;
        margin-bottom: 16px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }

    .stat-trend {
        font-size: 14px;
        color: #52c41a;
    }

    .stat-trend.down {
        color: #ff4d4f;
    }

    /* 图表容器样式 */
    .charts-container {
        margin-top: 24px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 24px;
    }

    .chart-card {
        background: #fff;
        padding: 24px;
        border-radius: 4px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .chart-title {
        font-size: 16px;
        color: #333;
    }

    .chart-actions {
        display: flex;
        gap: 8px;
    }

    .chart-action {
        padding: 4px 8px;
        border: 1px solid #d9d9d9;
        border-radius: 2px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .chart-action:hover {
        color: #1890ff;
        border-color: #1890ff;
    }
</style>
@endsection
