import React, { useState } from 'react';
import {
    Breadcrumb, Layout, Menu, theme, ConfigProvider, App
} from 'antd';
import Dashboard from './custom-components/dashboard';
import Blocks from './custom-components/blocks';
import Templates from './custom-components/templates';
import Settings from './custom-components/settings';
import License from './custom-components/license';
import { DashboardOutlined, SettingOutlined, BlockOutlined, PicRightOutlined, KeyOutlined } from '@ant-design/icons';
import { icons } from 'antd/es/image/PreviewGroup';


const { Header, Content, Footer } = Layout;


const isProInstalled = typeof boldpo !== 'undefined' && !!boldpo.isProInstalled;

const items = [
    {
        key: 'blocks',
        label: 'Blocks',
        icon: <BlockOutlined />
    },
    {
        key: 'templates',
        label: 'Templates',
        icon: <PicRightOutlined />
    },
    {
        key: 'settings',
        label: 'Settings',
        icon: <SettingOutlined />
    },
    ...(isProInstalled ? [{
        key: 'license',
        label: 'License',
        icon: <KeyOutlined />
    }] : [])
]

const ThemeData = {
    borderRadius: 2,
    colorPrimary: '#a216ffff',
    Button: {
        colorPrimary: '#a216ffff',
        algorithm: true,
    }
};


export default function BoldPostApp() {

    const {
        token: { colorBgContainer, borderRadiusLG },
    } = theme.useToken();

    const [current, setCurrent] = useState('blocks');

    const changeMenu = (e) => {
        setCurrent(e.key);
        console.log('key', e.key);

    }

    return (

        <ConfigProvider theme={{ token: ThemeData }}>
            <App>
                <Layout>
                    <Header style={{ display: 'flex', alignItems: 'center', background: '#fff' }}>
                        <div className="boldpo-logo">
                            <img src={boldpo.boldpoUrl + 'public/assets/img/icons/plugin-icon-200_200.svg'} alt="boldpo-logo" />
                        </div>
                        <Menu
                            theme="light"
                            mode="horizontal"
                            defaultSelectedKeys={['dashboard']}
                            items={items}
                            style={{ flex: 1, minWidth: 0, fontWeight: 'bold' }}
                            onClick={changeMenu}
                        />
                    </Header>
                    <Content style={{ padding: '0 48px', margin: '24px 0' }}>
                        <div
                            style={{
                                background: colorBgContainer,
                                minHeight: 280,
                                padding: 24,
                                borderRadius: borderRadiusLG,
                            }}
                        >

                            {current === 'blocks' && <Blocks />}
                            {current === 'templates' && <Templates />}
                            {current === 'settings' && <Settings />}
                            {current === 'license' && isProInstalled && <License />}

                        </div>
                    </Content>
                    <Footer style={{ textAlign: 'center' }}>
                        BoldPost ©{new Date().getFullYear()} Created by Themewant
                    </Footer>
                </Layout>
            </App >
        </ConfigProvider>

    );
}