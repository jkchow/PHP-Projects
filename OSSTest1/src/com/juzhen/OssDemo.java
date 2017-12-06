package com.juzhen;

import java.io.File;

import com.aliyun.oss.ClientException;
import com.aliyun.oss.OSSClient;
import com.aliyun.oss.OSSException;
import com.aliyun.oss.model.CannedAccessControlList;
import com.aliyun.oss.model.PutObjectResult;

public class OssDemo {



	public static void main(String[] args) {
		String endpoint = "http://oss-cn-beijing.aliyuncs.com";
		// 云账号AccessKey有所有API访问权限，建议遵循阿里云安全最佳实践，创建并使用RAM子账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建
		String accessKeyId = "LTAI1hcUoWNnanft";
		String accessKeySecret = "crkULa7xAoV6WPMYZpq4wHkHxmESZq";
		// 创建OSSClient实例
		OSSClient ossClient = new OSSClient(endpoint, accessKeyId, accessKeySecret);
		//String bucketName="juzhencms2";
		//setBucketPublicReadable(ossClient,bucketName);
		// 上传文件
		PutObjectResult putObject = ossClient.putObject("juzhencms", "test3.jpg", new File("D:\\abc.jpg"));
		System.out.println("success?");
		System.out.println(putObject.getETag());
		// 关闭client	
		ossClient.shutdown();
		
	}
	
    private static void setBucketPublicReadable(OSSClient client, String bucketName)throws OSSException, ClientException{
        //创建bucket
        client.createBucket(bucketName);
        //设置bucket的访问权限， public-read权限
        client.setBucketAcl(bucketName, CannedAccessControlList.PublicRead);
    }
	

}
