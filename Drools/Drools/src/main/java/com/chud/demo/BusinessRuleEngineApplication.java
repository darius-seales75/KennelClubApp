package com.chud.demo;

import java.util.Arrays;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.ApplicationContext;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.ComponentScan;

@SpringBootApplication
@ComponentScan(basePackages = {"com.chud.demo.*"})
public class BusinessRuleEngineApplication {

	/*
	 * @Autowired private ApplicationContext applicationContext;
	 */

	public static void main(String[] args) {
		SpringApplication.run(BusinessRuleEngineApplication.class, args);
	}

	@Bean
	public CommandLineRunner run(ApplicationContext appContext) {
		return args -> {
			String[] beans = appContext.getBeanDefinitionNames();
			//Arrays.stream(beans).sorted().forEach(System.out::println);
		};
	}
	
	/*
	 * @Autowired public void applicationContext(ApplicationContext context) {
	 * this.applicationContext = context; }
	 */

}
